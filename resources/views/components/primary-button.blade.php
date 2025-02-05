<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary mt-2 mb-2']) }}>
    {{ $slot }}
</button>
