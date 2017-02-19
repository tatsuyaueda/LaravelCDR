'use strict';

import Echo from "laravel-echo"
//import $ from 'jquery'

// Socket IOが定義されているか、LoginUserIDが0以外か(0はログインしていない)
if (typeof(io) != "undefined" && laravelLogginUserID != 0) {
    initLaravelEcho();
}

/**
 * Laravel Echoの初期化
 */
function initLaravelEcho() {

    // Laravel Echoに接続
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: window.location.hostname + ':6001'
    });

    window.Echo.connector.socket.on('disconnect', function () {
        $('#laravelEchoStatus')
            .removeClass(function (index, className) {
                return (className.match(/\bfa-bell\S+/g) || []).join(' ');
            })
            .addClass('fa-bell-slash-o');
        console.log('disconnect');
    });

    window.Echo.connector.socket.on('connect', function () {
        $('#laravelEchoStatus')
            .removeClass(function (index, className) {
                return (className.match(/\bfa-bell\S+/g) || []).join(' ');
            })
            .addClass('fa-bell-o');
        console.log('connect');
    });

    window.Echo.connector.socket.on('reconnect', function () {
        $('#laravelEchoStatus')
            .removeClass(function (index, className) {
                return (className.match(/\bfa-bell\S+/g) || []).join(' ');
            })
            .addClass('fa-bell-o');
        console.log('reconnect');
    });

    // ToDo: Broadcastはログインして無くても購読できちゃう
    // BroadcastチャンネルにJoin
    window.Echo.channel('BroadcastChannel')
        .listen('MessageCreateBroadcastEvent', (e) => {
            console.log('MessageCreateBroadcastEvent');
            console.log(e);
        })
        .listen('UpdateExtStatusEvent', (e) => {
            // 内線情報の更新
            console.log('UpdateExtStatusEvent');
            console.log(e);

            var msg = JSON.parse(e.message.message);

            procUpdateExtStatus(msg.ExtNo, msg.ExtStatus);
        });

    // PrivateチャンネルにJoin
    window.Echo.private('PrivateChannel.' + laravelLogginUserID)
        .listen('MessageCreatePrivateEvent', (e) => {
            console.log('PrivateChannel');
            console.log(e);
        })
        .listen('IncomingCallEvent', (e) => {
            // 着信があった場合
            console.log('IncomingCallEvent');
            console.log(e);

            var msg = JSON.parse(e.message.message);

            incomingCall(msg.Number, msg.DisplayName);
        });

}

/**
 * 着信があった場合
 * @param number
 * @param displayName
 */
function incomingCall(number, displayName) {

    PNotify.desktop.permission();

    new PNotify({
        title: number + '着信中',
        text: displayName + 'さんから着信中です。',
        type: 'info',
        desktop: {
            desktop: true
        }
    });

}

/**
 * 内線状態の更新
 * @param ext
 * @param status
 */
function procUpdateExtStatus(ext, status) {

    // 内線情報のアップデート
    $('i.fa.fa-circle.extStatus.ext' + ext)
        .removeClass(function (index, className) {
            return (className.match(/\btext-\S+/g) || []).join(' ');
        })
        .addClass(extStatus[status]['statusClass'])
        .attr('title', extStatus[status]['statusText']);

}