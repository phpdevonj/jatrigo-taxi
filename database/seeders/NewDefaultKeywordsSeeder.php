<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Screen;
use App\Models\DefaultKeyword;

class NewDefaultKeywordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $screen_data = [

            [
                "screenID" => "1",
                "ScreenName" => "WalkThroughScreen",
                "keyword_data" => [
                    [
                        "screenId" => "1",
                        "keyword_id" => 401,
                        "keyword_name" => "getStarted",
                        "keyword_value" => "Get Started"
                    ],
                ]
            ],

            [
                "screenID" => "2",
                "ScreenName" => "Register Screen",
                "keyword_data" => [
                    [
                        "screenId" => "2",
                        "keyword_id" => 413,
                        "keyword_name" => "signUpToGetStarted",
                        "keyword_value" => "Sign up to get Started"
                    ],
                    [
                        "screenId" => "2",
                        "keyword_id" => 414,
                        "keyword_name" => "termsAndConditions",
                        "keyword_value" => "Terms & Conditions"
                    ],
                    [
                        "screenId" => "2",
                        "keyword_id" => 415,
                        "keyword_name" => "signIn",
                        "keyword_value" => "Sign In"
                    ],
                ]
            ],

            [
                "screenID" => "3",
                "ScreenName" => "Login Screen",
                "keyword_data" => [
                    [
                        "screenId" => "3",
                        "keyword_id" => 403,
                        "keyword_name" => "welcomeBack",
                        "keyword_value" => "Welcome Back"
                    ],
                    [
                        "screenId" => "3",
                        "keyword_id" => 404,
                        "keyword_name" => "signInToContinue",
                        "keyword_value" => "Sign In to Continue"
                    ],
                    [
                        "screenId" => "3",
                        "keyword_id" => 407,
                        "keyword_name" => "signInUsingYourMobileNumberSubtitle",
                        "keyword_value" => "We'll send you a one-time code to verify your number"
                    ],
                    [
                        "screenId" => "3",
                        "keyword_id" => 408,
                        "keyword_name" => "verifyYourNumber",
                        "keyword_value" => "Verify your Number"
                    ],
                    [
                        "screenId" => "3",
                        "keyword_id" => 409,
                        "keyword_name" => "enterThe6DigitCodeWeVeSentByTextTo",
                        "keyword_value" => "Enter the 6 digit code we’ve sent by text to"
                    ],
                    [
                        "screenId" => "3",
                        "keyword_id" => 410,
                        "keyword_name" => "didNotReceiveTheCode",
                        "keyword_value" => "Didn’t receive the code?"
                    ],
                    [
                        "screenId" => "3",
                        "keyword_id" => 411,
                        "keyword_name" => "reSend",
                        "keyword_value" => "Re-send"
                    ],
                    [
                        "screenId" => "3",
                        "keyword_id" => 412,
                        "keyword_name" => "verifyOTP",
                        "keyword_value" => "Verify OTP"
                    ],
                    [
                        "screenId" => "3",
                        "keyword_id" => 454,
                        "keyword_name" => "enter_your_mobile_number_to_receive_a_verification_code",
                        "keyword_value" => "Enter your mobile number to receive a verification code"
                    ],
                ]
            ],

            [
                "screenID" => "4",
                "ScreenName" => "Forget Password Screen",
                "keyword_data" => [
                    [
                        "screenId" => "4",
                        "keyword_id" => 405,
                        "keyword_name" => "forgotPasswordSubtitle",
                        "keyword_value" => "Don't worry; even the best of us misplace things sometimes. Let's get you back in!"
                    ],
                    [
                        "screenId" => "4",
                        "keyword_id" => 406,
                        "keyword_name" => "send",
                        "keyword_value" => "Send"
                    ],
                ]
            ],

            [
                "screenID" => "5",
                "ScreenName" => "Dashboard Screen",
                "keyword_data" => [
                    [
                        "screenId" => "5",
                        "keyword_id" => 445,
                        "keyword_name" => "upcomingRideRequest",
                        "keyword_value" => "Upcoming Ride Request"
                    ],
                    [
                        "screenId" => "5",
                        "keyword_id" => 446,
                        "keyword_name" => "youHavePendingRideRequests",
                        "keyword_value" => "You have pending ride requests"
                    ],
                    [
                        "screenId" => "5",
                        "keyword_id" => 447,
                        "keyword_name" => "noDataFound",
                        "keyword_value" => "No Data Found"
                    ],
                    [
                        "screenId" => "5",
                        "keyword_id" => 449,
                        "keyword_name" => "weAreSorry",
                        "keyword_value" => "We are sorry,"
                    ],
                    [
                        "screenId" => "5",
                        "keyword_id" => 456,
                        "keyword_name" => "sample_text",
                        "keyword_value" => "Sample Text"
                    ],
                ]
            ],

            [
                "screenID" => "7",
                "ScreenName" => "Profile Screen",
                "keyword_data" => [
                    [
                        "screenId" => "7",
                        "keyword_id" => 416,
                        "keyword_name" => "streetAddress",
                        "keyword_value" => "Street Address:"
                    ],
                    [
                        "screenId" => "7",
                        "keyword_id" => 417,
                        "keyword_name" => "town",
                        "keyword_value" => "Town:"
                    ],
                    [
                        "screenId" => "7",
                        "keyword_id" => 418,
                        "keyword_name" => "city",
                        "keyword_value" => "City:"
                    ],
                    [
                        "screenId" => "7",
                        "keyword_id" => 419,
                        "keyword_name" => "postCode",
                        "keyword_value" => "Post Code:"
                    ],
                    [
                        "screenId" => "7",
                        "keyword_id" => 420,
                        "keyword_name" => "country",
                        "keyword_value" => "Country:"
                    ],
                    [
                        "screenId" => "7",
                        "keyword_id" => 430,
                        "keyword_name" => "addressType",
                        "keyword_value" => "Address Type"
                    ],
                    [
                        "screenId" => "7",
                        "keyword_id" => 431,
                        "keyword_name" => "customAddressType",
                        "keyword_value" => "Custom Address Type"
                    ],
                ]
            ],

            [
                "screenID" => "9",
                "ScreenName" => "Ride Details Screen",
                "keyword_data" => [
                    [
                        "screenId" => "9",
                        "keyword_id" => 450,
                        "keyword_name" => "confirmYourBooking",
                        "keyword_value" => "Confirm Your Booking"
                    ],
                    [
                        "screenId" => "9",
                        "keyword_id" => 451,
                        "keyword_name" => "BookingIsReady",
                        "keyword_value" => "Your ride is ready to be booked. Do you want to proceed?"
                    ],
                ]
            ],

            [
                "screenID" => "25",
                "ScreenName" => "Ride Status Screen",
                "keyword_data" => [
                    [
                        "screenId" => "25",
                        "keyword_id" => 402,
                        "keyword_name" => "coupon_subtitle",
                        "keyword_value" => "You can enter or Select Promo code"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 421,
                        "keyword_name" => "promoCode",
                        "keyword_value" => "Promo Code"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 422,
                        "keyword_name" => "applied",
                        "keyword_value" => "Applied"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 423,
                        "keyword_name" => "apply",
                        "keyword_value" => "Apply"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 424,
                        "keyword_name" => "callDriver",
                        "keyword_value" => "Call Driver"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 425,
                        "keyword_name" => "whyDoYouWantToCancelTheRide",
                        "keyword_value" => "Why do you want to cancel the ride?"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 427,
                        "keyword_name" => "discount",
                        "keyword_value" => "Discount"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 428,
                        "keyword_name" => "upcoming",
                        "keyword_value" => "Upcoming"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 429,
                        "keyword_name" => "history",
                        "keyword_value" => "History"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 453,
                        "keyword_name" => "schedule_ride",
                        "keyword_value" => "Schedule Ride"
                    ],
                ]
            ],

            [
                "screenID" => "27",
                "ScreenName" => "Review Screen",
                "keyword_data" => [
                    [
                        "screenId" => "27",
                        "keyword_id" => 426,
                        "keyword_name" => "addCustomTip",
                        "keyword_value" => "Add custom tip"
                    ],
                ]
            ],

            [
                "screenID" => "33",
                "ScreenName" => "Chat Screen",
                "keyword_data" => [
                    [
                        "screenId" => "33",
                        "keyword_id" => 432,
                        "keyword_name" => "Messages",
                        "keyword_value" => "Messages"
                    ],
                ]
            ],

            [
                "screenID" => "37",
                "ScreenName" => "Document Screen",
                "keyword_data" => [
                    [
                        "screenId" => "37",
                        "keyword_id" => 433,
                        "keyword_name" => "timeAreEstimated",
                        "keyword_value" => "Times are estimated based on predicated traffic. Actual traffic impact your drop-off time"
                    ],
                    [
                        "screenId" => "37",
                        "keyword_id" => 434,
                        "keyword_name" => "chooseTime",
                        "keyword_value" => "Choose a time"
                    ],
                    [
                        "screenId" => "37",
                        "keyword_id" => 435,
                        "keyword_name" => "pickUpAt",
                        "keyword_value" => "Pick-up at"
                    ],
                    [
                        "screenId" => "37",
                        "keyword_id" => 436,
                        "keyword_name" => "selectDate",
                        "keyword_value" => "Select Date"
                    ],
                    [
                        "screenId" => "37",
                        "keyword_id" => 437,
                        "keyword_name" => "selectTime",
                        "keyword_value" => "Select Time"
                    ],
                    [
                        "screenId" => "37",
                        "keyword_id" => 438,
                        "keyword_name" => "selectProperLocation",
                        "keyword_value" => "Please select proper location"
                    ],
                    [
                        "screenId" => "37",
                        "keyword_id" => 439,
                        "keyword_name" => "cancelRequest",
                        "keyword_value" => "Cancel Request"
                    ],
                    [
                        "screenId" => "37",
                        "keyword_id" => 440,
                        "keyword_name" => "allScheduledRides",
                        "keyword_value" => "All Scheduled Rides"
                    ],
                    [
                        "screenId" => "37",
                        "keyword_id" => 441,
                        "keyword_name" => "uploadDocument",
                        "keyword_value" => "Upload Document"
                    ],
                    [
                        "screenId" => "37",
                        "keyword_id" => 442,
                        "keyword_name" => "uploadYourDocuments",
                        "keyword_value" => "Upload your Documents"
                    ],
                    [
                        "screenId" => "37",
                        "keyword_id" => 443,
                        "keyword_name" => "carInfo",
                        "keyword_value" => "Car Info"
                    ],
                    [
                        "screenId" => "37",
                        "keyword_id" => 444,
                        "keyword_name" => "thisFieldIsRequired",
                        "keyword_value" => "This field is required"
                    ],
                ]
            ],

            [
                "screenID" => "40",
                "ScreenName" => "Loyalty Screen",
                "keyword_data" => [
                    [
                        "screenId" => "40",
                        "keyword_id" => 380,
                        "keyword_name" => "loyalty_points",
                        "keyword_value" => "Loyalty Points"
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 381,
                        "keyword_name" => "points",
                        "keyword_value" => "Points"
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 382,
                        "keyword_name" => "transfer_to_wallet",
                        "keyword_value" => "Transfer to wallet"
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 383,
                        "keyword_name" => "your_total_points_is",
                        "keyword_value" => "Your Total points is"
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 384,
                        "keyword_name" => "enter_points",
                        "keyword_value" => "Enter points"
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 385,
                        "keyword_name" => "your_amount",
                        "keyword_value" => "Your amount"
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 386,
                        "keyword_name" => "transfer",
                        "keyword_value" => "Transfer"
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 387,
                        "keyword_name" => "point_history",
                        "keyword_value" => "Point History"
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 388,
                        "keyword_name" => "earn_cash_with_loyalty_points",
                        "keyword_value" => "Earn Cash with Loyalty Points!"
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 389,
                        "keyword_name" => "every_time_you_make_a_trip",
                        "keyword_value" => "Every time you make a trip, you earn loyalty points..."
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 390,
                        "keyword_name" => "how_it_works",
                        "keyword_value" => "How it works:"
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 391,
                        "keyword_name" => "earn_points_on_every_ride",
                        "keyword_value" => "Earn points on every Ride."
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 392,
                        "keyword_name" => "redeem_points_for_discounts",
                        "keyword_value" => "Redeem points for discounts"
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 393,
                        "keyword_name" => "track_your_points_easily_in_your_account_dashboard",
                        "keyword_value" => "Track your points easily in your account dashboard."
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 394,
                        "keyword_name" => "you_have_withdrawn",
                        "keyword_value" => "You have withdrawn"
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 395,
                        "keyword_name" => "transfer_id_is",
                        "keyword_value" => "Transfer ID is"
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 396,
                        "keyword_name" => "you_have_earned",
                        "keyword_value" => "You have Earned."
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 397,
                        "keyword_name" => "trip_completed_by_you_trip_id_is",
                        "keyword_value" => "Ride completed by you. Ride id is"
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 398,
                        "keyword_name" => "pleaseEnterPoints",
                        "keyword_value" => "Please enter points"
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 399,
                        "keyword_name" => "your_points_must_be_greater_than_zero",
                        "keyword_value" => "Your points must be greater than zero."
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 400,
                        "keyword_name" => "your_points_is_more_than_your_total_points",
                        "keyword_value" => "Your points is more than your total points."
                    ],
                    [
                        "screenId" => "40",
                        "keyword_id" => 448,
                        "keyword_name" => "youHaveBeenAwarded",
                        "keyword_value" => "You have been awarded"
                    ],
                    [
                        "screenId" => "34",
                        "keyword_id" => 452,
                        "keyword_name" => "estTime",
                        "keyword_value" => "Est. Time"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 458,
                        "keyword_name" => "rideEstimate",
                        "keyword_value" => "Ride Estimate"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 457,
                        "keyword_name" => "driverArriveIn",
                        "keyword_value" => "Driver arriving in"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 459,
                        "keyword_name" => "referralCode",
                        "keyword_value" => "Referral Code"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 460,
                        "keyword_name" => "referNEarn",
                        "keyword_value" => "Refer & Earn"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 461,
                        "keyword_name" => "ridesHistory",
                        "keyword_value" => "Rides History"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 462,
                        "keyword_name" => "chooseTime",
                        "keyword_value" => "Choose Time"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 463,
                        "keyword_name" => "pickUpAt",
                        "keyword_value" => "Pick Up At"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 464,
                        "keyword_name" => "selectDate",
                        "keyword_value" => "Select Date"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 465,
                        "keyword_name" => "selectTime",
                        "keyword_value" => "Select Time"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 466,
                        "keyword_name" => "timeAreEstimated",
                        "keyword_value" => "Times are estimated based on predicated traffic.Actual traffic impact your drop-off time.Cancel for free up to an an hour before pickup."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 467,
                        "keyword_name" => "referFriend",
                        "keyword_value" => "Refer Friend"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 468,
                        "keyword_name" => "referFriendDescription",
                        "keyword_value" => "When your friends sign up this referral code, you can receive a"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 469,
                        "keyword_name" => "YourCodeToInvite",
                        "keyword_value" => "Your code to invite"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 470,
                        "keyword_name" => "referralCodeCopied",
                        "keyword_value" => "Referral code copied!"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 471,
                        "keyword_name" => "totalNumberOfRefers",
                        "keyword_value" => "Total Number of Refers"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 472,
                        "keyword_name" => "invite",
                        "keyword_value" => "Invite"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 473,
                        "keyword_name" => "card",
                        "keyword_value" => "Card"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 474,
                        "keyword_name" => "addCard",
                        "keyword_value" => "Add Card"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 475,
                        "keyword_name" => "lblDefaultCard",
                        "keyword_value" => "Note: No saved card found. Please add a card and set it as default to continue with the booking."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 476,
                        "keyword_name" => "noDefaultCard",
                        "keyword_value" => "Unable to proceed: No default card found. Please add and select one to continue."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 477,
                        "keyword_name" => "BookingIsReady",
                        "keyword_value" => "Your ride is ready to be booked. Do you want to proceed now?"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 478,
                        "keyword_name" => "okay",
                        "keyword_value" => "Okay"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 479,
                        "keyword_name" => "totalChargedAmount",
                        "keyword_value" => "Total charged amount"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 480,
                        "keyword_name" => "transactions",
                        "keyword_value" => "Transactions"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 481,
                        "keyword_name" => "myCards",
                        "keyword_value" => "My Cards"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 482,
                        "keyword_name" => "rideOtp",
                        "keyword_value" => "Safety Code"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 483,
                        "keyword_name" => "state",
                        "keyword_value" => "State"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 484,
                        "keyword_name" => "customAddressType",
                        "keyword_value" => "Custom Address Type"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 485,
                        "keyword_name" => "addressType",
                        "keyword_value" => "Address Type"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 486,
                        "keyword_name" => "areYouSure",
                        "keyword_value" => "Are you sure?"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 487,
                        "keyword_name" => "doYouWantToDeleteCard",
                        "keyword_value" => "Do you want to delete this card?"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 488,
                        "keyword_name" => "rideAmount",
                        "keyword_value" => "Ride Amount"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 489,
                        "keyword_name" => "markAsAllRead",
                        "keyword_value" => "Mark all as read"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 490,
                        "keyword_name" => "newDriver",
                        "keyword_value" => "New Driver"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 491,
                        "keyword_name" => "dueToHighDemand",
                        "keyword_value" => "Due to high demand, a fixed pricing adjustment was applied at the time of booking."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 492,
                        "keyword_name" => "appliedAsAFixedChargeDueToCurrentDemand",
                        "keyword_value" => "Applied as a fixed charge due to current demand"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 493,
                        "keyword_name" => "gotIt",
                        "keyword_value" => "Got it"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 494,
                        "keyword_name" => "lblPayWithDefaultCard",
                        "keyword_value" => "Pay with default card"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 495,
                        "keyword_name" => "minimumTipForCardIs",
                        "keyword_value" => "Minimum tip for card is"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 496,
                        "keyword_name" => "pleaseAddACardToPayTip",
                        "keyword_value" => "Please add a card to pay tip"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 497,
                        "keyword_name" => "insufficientWalletBalanceForTip",
                        "keyword_value" => "Insufficient wallet balance for tip"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 498,
                        "keyword_name" => "typeYourCountryName",
                        "keyword_value" => "Type your country name"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 499,
                        "keyword_name" => "now",
                        "keyword_value" => "Now"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 500,
                        "keyword_name" => "schedule",
                        "keyword_value" => "Schedule"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 501,
                        "keyword_name" => "whereYouWantToGo",
                        "keyword_value" => "Where you want to go?"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 502,
                        "keyword_name" => "home",
                        "keyword_value" => "Home"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 503,
                        "keyword_name" => "work",
                        "keyword_value" => "Work"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 504,
                        "keyword_name" => "pleaseSelectDateAndTime",
                        "keyword_value" => "Please select date and time"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 505,
                        "keyword_name" => "pleaseSelectDate",
                        "keyword_value" => "Please select date"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 506,
                        "keyword_name" => "pleaseSelectTime",
                        "keyword_value" => "Please select time"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 507,
                        "keyword_name" => "gettingYourRefererCode",
                        "keyword_value" => "Get your referral code"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 508,
                        "keyword_name" => "cancelRequest",
                        "keyword_value" => "Cancel Request"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 509,
                        "keyword_name" => "confirmCancellation",
                        "keyword_value" => "Confirm Cancellation"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 510,
                        "keyword_name" => "whyAreYouCancelling",
                        "keyword_value" => "Why are you cancelling?"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 511,
                        "keyword_name" => "cardAddedSuccessfully",
                        "keyword_value" => "Card added successfully"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 512,
                        "keyword_name" => "theProvidedPhoneNumberIsNotValid",
                        "keyword_value" => "The provided phone number is not valid."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 513,
                        "keyword_name" => "rideIsInProgressYouCanTCancelIt",
                        "keyword_value" => "Ride is in progress. You can't cancel it."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 514,
                        "keyword_name" => "selectProperLocationRequired",
                        "keyword_value" => "Select Proper Location required"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 515,
                        "keyword_name" => "cropProfileImage1",
                        "keyword_value" => "Crop Profile Image"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 516,
                        "keyword_name" => "externalWallet",
                        "keyword_value" => "EXTERNAL_WALLET:"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 517,
                        "keyword_name" => "testPayment",
                        "keyword_value" => "Test Payment"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 518,
                        "keyword_name" => "storagePermissionRequiredToDownloadPdf",
                        "keyword_value" => "Storage permission required to download PDF"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 519,
                        "keyword_name" => "invoiceDownloadedSuccessfully",
                        "keyword_value" => "Invoice downloaded successfully"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 520,
                        "keyword_name" => "errorDownloadedFileNotFound",
                        "keyword_value" => "Error: Downloaded file not found"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 521,
                        "keyword_name" => "errorDownloadingPdf",
                        "keyword_value" => "Error downloading PDF"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 522,
                        "keyword_name" => "failedToDownloadPdf",
                        "keyword_value" => "Failed to download PDF"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 523,
                        "keyword_name" => "paymentHasBeenCompletedSuccessfully",
                        "keyword_value" => "Payment has been completed successfully."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 524,
                        "keyword_name" => "failedToPickImageFromGallery",
                        "keyword_value" => "Failed to pick image from gallery"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 525,
                        "keyword_name" => "failedToPickImageFromCamera",
                        "keyword_value" => "Failed to pick image from camera"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 526,
                        "keyword_name" => "googleMapMbNotAvailable",
                        "keyword_value" => "Google map mb not available"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 527,
                        "keyword_name" => "somethingWentWrongPleaseTryAgain",
                        "keyword_value" => "Something went wrong. Please try again."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 528,
                        "keyword_name" => "otpResentSuccessfully",
                        "keyword_value" => "OTP Resent Successfully"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 529,
                        "keyword_name" => "otpIsRequired",
                        "keyword_value" => "OTP is required"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 530,
                        "keyword_name" => "pleaseEnterAValid6DigitOtp",
                        "keyword_value" => "Please enter a valid 6-digit OTP"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 531,
                        "keyword_name" => "cardDeleted",
                        "keyword_value" => "🗑️ Card deleted"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 532,
                        "keyword_name" => "defaultCardSet",
                        "keyword_value" => "Default card set"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 533,
                        "keyword_name" => "expires",
                        "keyword_value" => "Expires:"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 534,
                        "keyword_name" => "refunded",
                        "keyword_value" => "Refunded:"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 535,
                        "keyword_name" => "transactionId",
                        "keyword_value" => "Transaction ID:"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 536,
                        "keyword_name" => "somethingWrong",
                        "keyword_value" => "Something wrong"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 537,
                        "keyword_name" => "thankYouForYourReview",
                        "keyword_value" => "Thank you for your review!"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 538,
                        "keyword_name" => "pleaseAddACardFirstToPayTip",
                        "keyword_value" => "Please add a card first to pay tip"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 539,
                        "keyword_name" => "invite1",
                        "keyword_value" => "Invite"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 540,
                        "keyword_name" => "or",
                        "keyword_value" => "OR"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 541,
                        "keyword_name" => "unauthenticated",
                        "keyword_value" => "Unauthenticated"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 542,
                        "keyword_name" => "pleaseSelectAnAddressType",
                        "keyword_value" => "Please select an address type"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 543,
                        "keyword_name" => "lblLoginSuccessfully",
                        "keyword_value" => "Login Successfully"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 544,
                        "keyword_name" => "lblCompleteYourProfile",
                        "keyword_value" => "Complete your profile"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 545,
                        "keyword_name" => "failedToLoadCards",
                        "keyword_value" => "Failed to load cards"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 546,
                        "keyword_name" => "deleteFailed",
                        "keyword_value" => "Delete Failed"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 547,
                        "keyword_name" => "failedToSetDefault",
                        "keyword_value" => "Failed to set default"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 548,
                        "keyword_name" => "failedToAddCard",
                        "keyword_value" => "Failed to add card"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 549,
                        "keyword_name" => "failedToProcessCardPayment",
                        "keyword_value" => "Failed to process card payment"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 550,
                        "keyword_name" => "stripeCustomerIdNotSet",
                        "keyword_value" => "Stripe customer ID not set in shared preferences."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 551,
                        "keyword_name" => "couldNotLoadSavedCards",
                        "keyword_value" => "Could not load saved cards."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 552,
                        "keyword_name" => "failedToAuthorizePayment",
                        "keyword_value" => "Failed to authorize payment"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 553,
                        "keyword_name" => "noPaymentIntentToCapture",
                        "keyword_value" => "No payment intent to capture"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 554,
                        "keyword_name" => "noPaymentIntentToCancel",
                        "keyword_value" => "No payment intent to cancel"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 555,
                        "keyword_name" => "stripeError",
                        "keyword_value" => "Stripe error"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 556,
                        "keyword_name" => "failedToSubmitReview",
                        "keyword_value" => "Failed to submit review"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 557,
                        "keyword_name" => "error",
                        "keyword_value" => "Error"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 558,
                        "keyword_name" => "canNotParseProvidedHex",
                        "keyword_value" => "Can not parse provided hex"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 559,
                        "keyword_name" => "invalidCountry",
                        "keyword_value" => "Invalid country"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 560,
                        "keyword_name" => "setupIntentFailedClientSecretNotReceived",
                        "keyword_value" => "SetupIntent failed. Client secret not received."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 561,
                        "keyword_name" => "customerIDNotSet",
                        "keyword_value" => "Customer ID not set"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 562,
                        "keyword_name" => "invalidCardDataFormat",
                        "keyword_value" => "Invalid card data format"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 563,
                        "keyword_name" => "retryRequest",
                        "keyword_value" => "RetryRequest"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 564,
                        "keyword_name" => "yourInternetIsNotaWorking",
                        "keyword_value" => "Your internet is not working"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 565,
                        "keyword_name" => "invalidPhoneNumber",
                        "keyword_value" => "Invalid phone number format"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 566,
                        "keyword_name" => "invalidMobileNumber",
                        "keyword_value" => "Invalid mobile number"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 567,
                        "keyword_name" => "invalidPhoneNumberFormat",
                        "keyword_value" => "Invalid phone number format"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 568,
                        "keyword_name" => "enterValidPhoneNumber",
                        "keyword_value" => "Enter valid phone number"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 569,
                        "keyword_name" => "pleaseSelectACountry",
                        "keyword_value" => "Please select a country"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 570,
                        "keyword_name" => "emailAlreadyInUse",
                        "keyword_value" => "The email address is already in use by another account."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 571,
                        "keyword_name" => "wrongPassword",
                        "keyword_value" => "Wrong email/password combination."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 572,
                        "keyword_name" => "noUserFound",
                        "keyword_value" => "No user found with this email."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 573,
                        "keyword_name" => "userDisabled",
                        "keyword_value" => "User disabled."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 574,
                        "keyword_name" => "tooManyRequests",
                        "keyword_value" => "Too many requests to log into this account."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 575,
                        "keyword_name" => "serverError",
                        "keyword_value" => "Server error, please try again later."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 576,
                        "keyword_name" => "invalidEmail",
                        "keyword_value" => "Email address is invalid."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 577,
                        "keyword_name" => "authenticationFailed",
                        "keyword_value" => "Authentication failed. Please enter a valid OTP and check your internet connection."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 578,
                        "keyword_name" => "invalidOtp",
                        "keyword_value" => "The OTP entered is invalid. Please try again."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 579,
                        "keyword_name" => "invalidVerificationId",
                        "keyword_value" => "Verification ID is invalid. Please resend the OTP."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 580,
                        "keyword_name" => "otpSessionExpired",
                        "keyword_value" => "The OTP session has expired. Please resend the OTP."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 581,
                        "keyword_name" => "networkConnectionFailed",
                        "keyword_value" => "Network connection failed. Please check your internet."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 582,
                        "keyword_name" => "smsQuotaExceeded",
                        "keyword_value" => "SMS quota exceeded. Please try again later."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 583,
                        "keyword_name" => "requestTimeout",
                        "keyword_value" => "Request timeout. Please try again later."
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 584,
                        "keyword_name" => "driverAccepted",
                        "keyword_value" => "Driver accepted"
                    ],
                    [
                        "screenId" => "25",
                        "keyword_id" => 585,
                        "keyword_name" => "scheduled",
                        "keyword_value" => "Scheduled"
                    ]
                ]
            ],

        ];

        // INSERT SCREEN AND KEYWORDS
        foreach ($screen_data as $screen) {

            $screen_record = Screen::firstOrCreate(
                ['screenId' => $screen['screenID']],
                ['screenName' => $screen['ScreenName']]
            );

            if (!empty($screen['keyword_data'])) {
                foreach ($screen['keyword_data'] as $keyword) {

                    DefaultKeyword::firstOrCreate(
                        ['keyword_id' => $keyword['keyword_id']],
                        [
                            'screen_id' => $screen_record->screenId,
                            'keyword_name' => $keyword['keyword_name'],
                            'keyword_value' => $keyword['keyword_value'],
                        ]
                    );
                }
            }
        }
    }
}