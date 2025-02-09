import { library, dom } from '@fortawesome/fontawesome-svg-core'

import {
    faTimes,
    faBars,
    faCalendar,
    faMapMarker,
    faUser,
    faEnvelope,
    faPhone,
    faBookmark,
    faFile,
    faMicrophone
} from '@fortawesome/free-solid-svg-icons'

import {
    faWhatsapp,
    faInstagram,
    faTelegram
} from "@fortawesome/free-brands-svg-icons";

library.add(faWhatsapp, faInstagram, faTelegram);

dom.watch();
