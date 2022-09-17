<div>
    <div x-data={}>
        <h1 x-text="$wire.count"></h1>
        <button class="btn btn-primary text-white"
                x-on:click="if (confirm('Confirm Icrement?')) {
                    cerrarSession()
                }">
            Push Me to Icerement
        </button>
    </div>
</div>
