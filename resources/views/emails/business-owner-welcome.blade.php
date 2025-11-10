@component('mail::message')
# Welcome to TrigStoreGh, {{ $user->name }}!

Congratulations! Your business profile has been successfully created.

## Your Account Details

**Name:** {{ $user->name }}  
**Email:** {{ $user->email }}  
@if($user->phone)
**Phone:** {{ $user->phone }}  
@endif
@if($user->address)
**Address:** {{ $user->address }}  
@endif

## Your Business Profile

**Business Name:** {{ $business->name }}  
**Business Code:** **{{ $business->business_code }}**  
@if($business->description)
**Description:** {{ $business->description }}  
@endif
@if($business->address)
**Business Address:** {{ $business->address }}  
@endif
@if($business->phone)
**Business Phone:** {{ $business->phone }}  
@endif
@if($business->email)
**Business Email:** {{ $business->email }}  
@endif
@if($business->website)
**Website:** {{ $business->website }}  
@endif

**Status:** {{ $business->is_active ? 'Active' : 'Inactive' }}

---

### Important: Your Business Code

Your unique business code is: **{{ $business->business_code }}**

Please keep this code safe as it will be used to identify your business in the system.

@component('mail::button', ['url' => config('app.url')])
Access Your Dashboard
@endcomponent

If you have any questions or need assistance, feel free to reach out to our support team.

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent

