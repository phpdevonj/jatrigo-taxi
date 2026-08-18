<?php
$auth_user = authSession();
?>
{{ Form::open(['route' => ['role.destroy', $role->id], 'method' => 'delete','data--submit'=>'role'.$role->id]) }}
<div class="d-flex justify-content-end align-items-center">
    @if( !in_array($role->name, ['rider', 'driver', 'fleet']) )
    @if($role->permissions()->count() == 0)
    <a class="mr-2 text-danger" href="javascript:void(0)" data--submit="role{{$role->id}}"
        data--confirmation='true' data-title="{{ __('message.delete_form_title',['form'=> __('message.role') ]) }}"
        title="{{ __('message.delete_form_title',['form'=>  __('message.role') ]) }}"
        data-message='{{ __("message.delete_msg") }}'>
        <i class="fas fa-trash-alt"></i>
    </a>
    @endif
    @endif
</div>
{{ Form::close() }}