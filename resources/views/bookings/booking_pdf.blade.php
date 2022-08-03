
<?php $full_path = env('MEDIA_PATH_HTTP');?>

<table>
	<tr>
		
		<td width="60%">
		
			@if(!empty($pharmacy_settings->logo_1))

	            <img src="{{ $full_path.'pharmacyprofile/'.$pharmacy_settings->logo_1 }}" width="300px" />

	        @endif

		</td>

		<td width="40%" style="text-align: right;">
			
			{{ $pharmacy_info->business_name }}
            
	        <br />

	        @php

	        $prescriber_address = '';

	        $prescriber_address .= ($prescriber_details->address_1) ? $prescriber_details->address_1 : '' ;
	        $prescriber_address .= ($prescriber_details->address_2) ? ', '.$prescriber_details->address_2 : '' ;
	        $prescriber_address .= ($prescriber_details->address_3) ? ', '.$prescriber_details->address_3 : '' ;
	        $prescriber_address .= ($prescriber_details->city) ? ', '.$prescriber_details->city : '' ;
	        $prescriber_address .= ($prescriber_details->postcode) ? ', '.$prescriber_details->postcode : '' ;

	        @endphp

	        {{ $prescriber_address }}
	        
	        <br />

	        Tel:

	        <a href="tel:{{ (!empty($prescriber_details->phone_no)) ? $prescriber_details->phone_no : '' }}">
	            
	            {{ (!empty($prescriber_details->phone_no)) ? $prescriber_details->phone_no : '' }}

	        </a>
	        
	        <br />
	        
	        Email:

	        <a href="mailto:{{ (!empty($prescriber_details->email)) ? $prescriber_details->email : '' }}">
	            
	            {{ (!empty($prescriber_details->email)) ? $prescriber_details->email : '' }}

	        </a>

	        <br />

	        <a href="{{ env('FRONT_WEBSITE_URL') }}" target="_blank">
	            
	            {{ env('FRONT_WEBSITE_URL') }}

	        </a>

		</td>

	</tr>
</table>

<br /> <br />

<p> IgM Test and PCR swab taken at the same time at the same site {{ $booking_details['pcr_test_date'] }}. </p>

<p>

    Client Name -

    {{ $patient_details['first_name'] }}
    {{ $patient_details['last_name'] }}

</p>

<p>
    Passport Number: {{ $patient_details['passport_number'] }}
</p>

<p>

    Date Of Birth - {{ date('d M Y', strtotime($patient_details['dob'])) }}

</p>

<p>

    UK Address - {{ $patient_details['address'] }}, {{ $patient_details['town_city'] }}, {{ $patient_details['postcode'] }}

</p>

<br /> <br /> <br />

<p>

    Igm result - 

    {{ empty($booking_details['igm_result']) || ( !empty($booking_details['igm_result'] && $booking_details['igm_result'] == 'Negative' ) ) ? 'Negative' : 'Positive' }}

</p>

<br /> <br /> <br />

<p>
    
    <strong> PCR test sent to our partner laboratory, Epistem Ltd, 48 Grafton Street, Incubator building, Manchester, M13 9XX for processing. </strong>

</p>

<br /> <br /> <br />

<p>
    
    Signed

    <br />

    @if(!empty(($prescriber_details->signature)))
        
        <img src="{{ $full_path.'signature/'.$prescriber_details->signature }}" class="img-fluid img-responsive" width="200px" />

    @endif

    <br />

    {{ $prescriber_details->first_name }}
    {{ $prescriber_details->last_name }}

    {{ $prescriber_details->qualification }},

    GPhC number {{ $prescriber_details->reg_no }}

    <br />

    Email address: <a href="mailto:{{ $prescriber_details->email }}"> {{ $prescriber_details->email }} </a>

</p>

<br /> <br /> <br /> <br />

<table>
	<tr>
		
		<td width="50%">&nbsp;</td>

		<td width="30%" style="font-style: 12px; float: right;">

            Company number {{ $pharmacy_info->company_number }}

            <br />

            VAT number {{ $pharmacy_info->vat_number }}

		</td>

		<td width="20%" style="">

			@if(!empty($pharmacy_settings->nhs_logo))

                <img src="{{ $full_path.'pharmacyprofile/'.$pharmacy_settings->nhs_logo }}" width="150px" />

            @endif

		</td>

	</tr>
</table>