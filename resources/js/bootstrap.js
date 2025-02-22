import axios from 'axios';
import Resumable from 'resumablejs';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Resumable = Resumable; // Attach Resumable to the window object