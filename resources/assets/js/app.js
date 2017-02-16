'use strict';

import Echo from "laravel-echo"

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});

window.Echo.channel('BroadcastChannel')
    .listen('MessageCreateBroadcastEvent', (e) => {
    console.log(e);
});


// ToDo : ユーザIDの埋め込み必要
window.Echo.private('PrivateChannel.1')
    .listen('MessageCreatePrivateEvent', (e) => {
    console.log(e);
});