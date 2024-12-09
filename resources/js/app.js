import './bootstrap';
import flatpickr from "flatpickr";
import ChartJS from 'chart.js/auto';
window.Chart = ChartJS;
import './../../vendor/power-components/livewire-powergrid/dist/powergrid';

import 'flatpickr/dist/flatpickr.min.css';

Alpine.magic('clipboard', () => {
    return subject => navigator.clipboard.writeText(subject)
})
