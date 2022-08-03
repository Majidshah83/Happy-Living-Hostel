
@if(!empty($orders))

	@php

	$total = count($orders);

	@endphp

	@foreach($orders as $index => $order)

		<br /> <br /> <br /> <br /> <br /> <br /> <br /> <br />


		<table width="100%">
			
			<tr>
				
				<td width="30%">

				</td>

				<td width="40%">
					
					<span style="font-size: 22px"> <strong> {{ $order->first_name }} {{ $order->surname }} </strong> </span>

				</td>

				<td width="30%">
					


				</td>

			</tr>

			<tr>
				
				<td width="30%">
					
				</td>

				<td width="40%">
					
					<br />

					<span style="font-size: 22px">

						{{ $order->uk_address }}

						<br />

						{{ $order->uk_city }}

						<br />

						{{ $order->uk_postcode }}

					</span>

				</td>

				<td width="30%">
					


				</td>

			</tr>

			<tr>
				
				<td width="30%">
					
				</td>

				<td width="40%">

					<br />
					
					<span style="font-size: 22px">

						<strong> Tel: </strong> {{ $order->phone_no }}

					</span>

				</td>

				<td width="30%">
					


				</td>

			</tr>

		</table>

		@if($index < $total)

			<pagebreak>

		@endif

	@endforeach
@endif