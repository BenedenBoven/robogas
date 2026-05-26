import AOS from 'aos';
import axios from 'axios';
import CookieNotification from "bb-cookie-notification";

import.meta.glob('../img/**');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

AOS.init();

new CookieNotification();
