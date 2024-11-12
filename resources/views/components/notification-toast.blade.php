<div id="toast-container" class="fixed bottom-4 right-4 z-50"></div>

@if (session()->has('toast'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.Toast.show(
                @json(session()->get('toast.message')),
                @json(session()->get('toast.type', 'success'))
            );
        });
    </script>
@endif
