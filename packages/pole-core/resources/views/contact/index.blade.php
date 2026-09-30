@extends( 'pole-core::layouts.website' )

@section( 'content' )
    @php
        $locale = app()->getLocale();
    @endphp

    <section style="border: 4px solid #6366f1;">
        <h1>{{ __( 'Contact us' ) }}</h1>

        @if ( session( 'notice' ) )
            <p>{{ session( 'notice' ) }}</p>
        @endif

        <form method="POST" action="{{ route( 'contact.store' ) }}">
            @csrf

            @if ( isset( $errors ) && $errors->any() )
                <ul>
                    @foreach ( $errors->all() as $error )
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <label for="name">{{ __( 'Name' ) }}</label>
            <input type="text" id="name" name="name" value="{{ old( 'name' ) }}" required>

            <label for="email">{{ __( 'Email' ) }}</label>
            <input type="email" id="email" name="email" value="{{ old( 'email' ) }}" required>

            <label for="message">{{ __( 'Message' ) }}</label>
            <textarea id="message" name="message" required>{{ old( 'message' ) }}</textarea>

            <button type="submit">{{ __( 'Send' ) }}</button>
        </form>
    </section>

    <section style="border: 4px solid #8b5cf6;">
        <h2>{{ __( 'Our team' ) }}</h2>

        @foreach ( $employees as $employee )
            <article>
                <h3>{{ $employee->full_name }}</h3>

                @if ( $employee->phone )
                    <p>{{ $employee->phone }}</p>
                @endif

                @if ( $employee->email )
                    <p><a href="mailto:{{ $employee->email }}">{{ $employee->email }}</a></p>
                @endif

                @if ( $employee->description[ $locale ] ?? null )
                    <div>{!! $employee->description[ $locale ] !!}</div>
                @endif
            </article>
        @endforeach
    </section>

    <section style="border: 4px solid #0ea5e9;">
        <h2>{{ __( 'Access' ) }}</h2>
        <p>{{ __( 'Avenue Frere Orban 9, 7000 Mons, Belgium' ) }}</p>
        <x-pole-core::map />
    </section>

    <x-pole-core::partners.listing />
    <x-pole-core::call.help />
@endsection
