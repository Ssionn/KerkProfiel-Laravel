<div id="toast-container" class="fixed bottom-4 right-4 z-50"></div>

@if (session()->has('toast'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.Toast.show(
                "{{ session()->get('toast.message') }}",
                "{{ session()->get('toast.type', 'success') }}"
            );
        });
    </script>
@endif
