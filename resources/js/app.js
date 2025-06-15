import Alpine from 'alpinejs'
window.Alpine = Alpine
if (window.Livewire) {
    window.Livewire.start();
}
Alpine.start()
require('./bootstrap');
require('@coreui/coreui/dist/js/coreui.bundle.min');
require('datatables.net-bs4');
require('datatables.net-buttons-bs4');
// $(function () {
//     $('[data-toggle="tooltip"]').tooltip()
// })

