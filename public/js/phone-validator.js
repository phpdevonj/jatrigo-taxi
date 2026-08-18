/**
 * phone-validator.js
 *
 * Client-side port of App\Rules\PhoneNumber (the server-side validation rule).
 * Keeping the logic identical means the browser accepts/rejects exactly what the
 * backend will, so users never pass client validation only to be rejected on save.
 *
 * Exposes:
 *   window.PhoneValidator.validate(e164String, opts) -> { valid, error, message, expected, callingCode, nationalLength }
 *   window.initPhoneField(itiInstance, inputEl, opts)  -> wires live validation (blur / countrychange) onto an intl-tel-input field
 */
(function (global) {
    'use strict';

    /** ITU-T E.164 hard limit on total digits (country code + national number). */
    var MAX_E164_DIGITS = 15;

    /** Fallback national-number length range for countries without an explicit entry. */
    var FALLBACK_MIN_NATIONAL = 4;
    var FALLBACK_MAX_NATIONAL = 14;

    /** Every valid country calling code (mirrors PhoneNumber::CALLING_CODES). */
    var CALLING_CODES = [
        '1', '20', '211', '212', '213', '216', '218', '220', '221', '222', '223',
        '224', '225', '226', '227', '228', '229', '230', '231', '232', '233',
        '234', '235', '236', '237', '238', '239', '240', '241', '242', '243',
        '244', '245', '246', '247', '248', '249', '250', '251', '252', '253',
        '254', '255', '256', '257', '258', '260', '261', '262', '263', '264',
        '265', '266', '267', '268', '269', '27', '290', '291', '297', '298',
        '299', '30', '31', '32', '33', '34', '350', '351', '352', '353', '354',
        '355', '356', '357', '358', '359', '36', '370', '371', '372', '373',
        '374', '375', '376', '377', '378', '380', '381', '382', '383', '385',
        '386', '387', '389', '39', '40', '41', '420', '421', '423', '43', '44',
        '45', '46', '47', '48', '49', '500', '501', '502', '503', '504', '505',
        '506', '507', '508', '509', '51', '52', '53', '54', '55', '56', '57',
        '58', '590', '591', '592', '593', '594', '595', '596', '597', '598',
        '599', '60', '61', '62', '63', '64', '65', '66', '670', '672', '673',
        '674', '675', '676', '677', '678', '679', '680', '681', '682', '683',
        '685', '686', '687', '688', '689', '690', '691', '692', '7', '81', '82',
        '84', '850', '852', '853', '855', '856', '86', '880', '886', '90', '91',
        '92', '93', '94', '95', '960', '961', '962', '963', '964', '965', '966',
        '967', '968', '970', '971', '972', '973', '974', '975', '976', '977',
        '98', '992', '993', '994', '995', '996', '998'
    ];

    /** Valid national-number length range [min, max] per calling code (mirrors PhoneNumber::NATIONAL_LENGTHS). */
    var NATIONAL_LENGTHS = {
        '1': [10, 10], '7': [10, 10], '20': [8, 10], '27': [9, 9], '30': [10, 10],
        '31': [9, 9], '32': [8, 9], '33': [9, 9], '34': [9, 9], '36': [8, 9],
        '39': [9, 11], '40': [9, 9], '41': [9, 9], '43': [4, 13], '44': [9, 10],
        '45': [8, 8], '46': [7, 9], '47': [8, 8], '48': [9, 9], '49': [6, 11],
        '51': [9, 9], '52': [10, 10], '54': [10, 11], '55': [10, 11], '56': [9, 9],
        '57': [10, 10], '58': [10, 10], '60': [7, 10], '61': [9, 9], '62': [8, 12],
        '63': [10, 10], '64': [8, 10], '65': [8, 8], '66': [9, 9], '81': [9, 10],
        '82': [9, 10], '84': [9, 10], '86': [7, 11], '90': [10, 10], '91': [10, 10],
        '92': [10, 10], '93': [9, 9], '94': [9, 9], '98': [10, 10], '211': [9, 9],
        '212': [9, 9], '213': [9, 9], '216': [8, 8], '218': [9, 9], '234': [8, 10],
        '249': [9, 9], '250': [9, 9], '251': [9, 9], '254': [9, 9], '255': [9, 9],
        '256': [9, 9], '260': [9, 9], '263': [9, 9], '351': [9, 9], '352': [9, 9],
        '353': [7, 9], '358': [5, 12], '380': [9, 9], '420': [9, 9], '421': [9, 9],
        '852': [8, 8], '853': [8, 8], '855': [8, 9], '856': [8, 10], '880': [10, 10],
        '886': [9, 9], '960': [7, 7], '961': [7, 8], '962': [9, 9], '963': [8, 9],
        '964': [10, 10], '965': [8, 8], '966': [9, 9], '967': [7, 9], '968': [8, 8],
        '970': [9, 9], '971': [9, 9], '972': [9, 9], '973': [8, 8], '974': [8, 8],
        '975': [8, 8], '976': [8, 8], '977': [10, 10], '992': [9, 9], '993': [8, 8],
        '994': [9, 9], '995': [9, 9], '996': [9, 9], '998': [9, 9]
    };

    var DEFAULT_MESSAGES = {
        invalid: 'Invalid contact number.',
        missingCountryCode: 'Contact number must include a country code.',
        invalidCountryCode: 'Invalid country calling code.',
        // ":country" and ":length" placeholders are substituted when available.
        lengthForCountry: 'Please enter a valid :country number (:length digits).'
    };

    function onlyDigits(str) {
        return (str == null ? '' : String(str)).replace(/\D+/g, '');
    }

    /**
     * Validate a number in international/E.164 form (e.g. "+919876543210").
     * Empty input is treated as valid here — "required" is enforced separately.
     */
    function validate(raw, opts) {
        opts = opts || {};
        var messages = Object.assign({}, DEFAULT_MESSAGES, global.PhoneValidatorMessages || {}, opts.messages || {});

        raw = (raw == null ? '' : String(raw)).trim();
        if (raw === '') {
            return { valid: true, error: null, message: '' };
        }

        var hasInternationalPrefix = raw.charAt(0) === '+' || raw.substr(0, 2) === '00';
        var digits = onlyDigits(raw);

        // Drop the "00" international access prefix if that was used.
        if (raw.charAt(0) !== '+' && raw.substr(0, 2) === '00') {
            digits = digits.substr(2);
        }

        if (digits === '') {
            return fail('invalid');
        }
        if (!hasInternationalPrefix) {
            return fail('missingCountryCode');
        }
        if (digits.length > MAX_E164_DIGITS) {
            return fail('invalid');
        }

        // Longest calling code (up to 4 digits) that prefixes the number.
        var callingCode = null;
        for (var len = Math.min(4, digits.length); len >= 1; len--) {
            if (CALLING_CODES.indexOf(digits.substr(0, len)) !== -1) {
                callingCode = digits.substr(0, len);
                break;
            }
        }
        if (callingCode === null) {
            return fail('invalidCountryCode');
        }

        var nationalLength = digits.length - callingCode.length;
        var range = NATIONAL_LENGTHS[callingCode] || [FALLBACK_MIN_NATIONAL, FALLBACK_MAX_NATIONAL];

        if (nationalLength < range[0] || nationalLength > range[1]) {
            return fail('invalid', range, callingCode, nationalLength);
        }

        return {
            valid: true, error: null, message: '',
            callingCode: callingCode, nationalLength: nationalLength
        };

        function fail(key, expected, cc, nl) {
            return {
                valid: false,
                error: key,
                message: messages[key] || DEFAULT_MESSAGES[key],
                expected: expected || null,
                callingCode: cc || callingCode,
                nationalLength: typeof nl === 'number' ? nl : null,
                _messages: messages
            };
        }
    }

    /**
     * Wire live validation onto an intl-tel-input field.
     *  - validates on blur and on country change (per the request)
     *  - clears the message as the user edits and whenever the country changes
     *  - builds a country-aware message (uses the selected country name + expected length)
     *  - blocks form submit while invalid and syncs the hidden full-number field
     */
    function initPhoneField(iti, input, opts) {
        opts = opts || {};
        if (!iti || !input || !global.jQuery) { return; }
        var $ = global.jQuery;
        var $input = $(input);
        var $group = $input.closest('.form-group');
        var messages = Object.assign({}, DEFAULT_MESSAGES, global.PhoneValidatorMessages || {}, opts.messages || {});

        // Ensure the intl-tel-input widget spans the full field width so the
        // message below it lines up with the input.
        var $wrap = $input.closest('.iti');
        if ($wrap.length) { $wrap.css('width', '100%'); }

        // Ensure a feedback element exists directly below the phone field.
        // Placed after the .iti wrapper (the visible widget) so it always sits
        // on its own line immediately beneath the input.
        var $anchor = $wrap.length ? $wrap : $input;
        var $err = ($group.length ? $group : $anchor.parent()).find('.js-phone-error').first();
        if (!$err.length) {
            $err = $('<div class="js-phone-error text-danger small mt-1" style="display:none; width:100%;"></div>');
            $anchor.after($err);
        }

        function countryName() {
            var d = iti.getSelectedCountryData ? iti.getSelectedCountryData() : null;
            return d && d.name ? d.name.replace(/\s*\(.*\)\s*$/, '') : '';
        }

        function e164() {
            var full = iti.getNumber ? iti.getNumber() : '';
            if (full) { return full; }
            // Fallback if utils.js has not finished loading yet.
            var d = iti.getSelectedCountryData ? iti.getSelectedCountryData() : null;
            var dial = d && d.dialCode ? d.dialCode : '';
            return dial ? '+' + dial + onlyDigits(input.value) : onlyDigits(input.value);
        }

        function messageFor(result) {
            if (result.error === 'invalid' && result.expected) {
                var min = result.expected[0], max = result.expected[1];
                var lenTxt = (min === max) ? String(min) : (min + '-' + max);
                var name = countryName();
                return (messages.lengthForCountry || DEFAULT_MESSAGES.lengthForCountry)
                    .replace(':country', name)
                    .replace(':length', lenTxt)
                    .replace(/\s{2,}/g, ' ')
                    .trim();
            }
            return result.message;
        }

        function showError(msg) {
            $err.html(msg).show();
            $group.addClass('has-danger');
            $("[type='submit']").addClass('disabled').prop('disabled', true);
        }
        function clearError() {
            $err.html('').hide();
            $group.removeClass('has-danger');
            $("[type='submit']").removeClass('disabled').prop('disabled', false);
        }

        function run() {
            var raw = (input.value || '').trim();
            if (raw === '') { clearError(); return true; }   // "required" handled elsewhere
            var result = validate(e164(), { messages: messages });
            if (result.valid) { clearError(); return true; }
            showError(messageFor(result));
            return false;
        }

        // Strip characters the number can never contain, as the user types.
        $input.on('input', function () {
            if (/[^0-9+\s.]/.test(this.value)) {
                this.value = this.value.replace(/[^0-9+\s.]/g, '');
            }
        });

        // Validate on blur; clear the visible error while editing.
        $input.on('blur keyup', run);
        $input.on('keyup change', function () {
            if ($err.is(':visible')) { clearError(); }
        });

        // Clear the previous country's error and re-check for the newly selected one.
        input.addEventListener('countrychange', function () {
            clearError();
            run();
        });

        // Block submit while invalid; otherwise sync the hidden E.164 number.
        var form = input.closest('form');
        if (form) {
            $(form).on('submit', function (e) {
                if (!run()) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    return false;
                }
                $("input[name='contact_number']").val(e164());
                return true;
            });
        }

        return { validate: run };
    }

    global.PhoneValidator = {
        validate: validate,
        CALLING_CODES: CALLING_CODES,
        NATIONAL_LENGTHS: NATIONAL_LENGTHS
    };
    global.initPhoneField = initPhoneField;
})(window);
