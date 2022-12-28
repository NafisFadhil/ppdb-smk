@extends('layouts.general')

@section('content')

{{-- Section Kontak --}}
<div class="w-full h-full bg-primary text-white">
	<div class="max-w-screen-lg mx-auto text-center px-4 sm:px-8 py-10 md:py-16">
		<h1 class="text-2xl md:text-4xl mb-1">Hubungi Kami</h1>
		<p class="mb-4"> Kontak WhatsApp customer service PPDB Online 2023. </p>
		<div class="flex flex-wrap flex-row justify-center items-center gap-3">
			@foreach($data_kontak as $row)
				<a href="https://wa.me/+62{{ substr($row,1) }}" target="_blank"
				class="bg-white text-primary rounded shadow-lg px-4 py-2 font-semibold">
					CS {{ $loop->iteration }} <i class="fab fa-whatsapp mx-1"></i> {{ $row }}
				</a>
			@endforeach
		</div>
	</div>
</div>

{{-- Section Sosmed --}}
<div class="w-full h-full bg-white">
	<div class="max-w-screen-lg mx-auto text-center px-4 sm:px-8 py-10 md:py-16">
		<h1 class="text-2xl md:text-4xl mb-1">Sosial Media Kami</h1>
		<p class="mb-4">Pantau informasi terbaru ppdb online 2023 melalui sosial media kami.</p>
		<div class="flex flex-wrap flex-row justify-center items-center gap-3">
			@foreach($data_sosmed as $name => $row)
				<a href="{{ $row['href'] }}" target="_blank"
				class="bg-primary text-white rounded shadow-lg px-4 py-2 font-semibold">
					<i class="{{ $row['icon'] }} mr-1"></i> {{ $row['label'] }}
				</a>
			@endforeach
		</div>
	</div>
</div>

<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3960.6102816722823!2d109.6487127!3d-6.9370938!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e70214ff6afc36b%3A0x5926432b08332cde!2sSMK%20Muhammadiyah%20Bligo!5e0!3m2!1sid!2sid!4v1672168300649!5m2!1sid!2sid"
width="100%" height="512" style="border:0;" allowfullscreen="true" loading="lazy"
referrerpolicy="no-referrer-when-downgrade"></iframe>

@endsection