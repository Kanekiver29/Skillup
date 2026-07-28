// resources/js/echo.js
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Allow server-rendered values via `window.Laravel` (recommended) and fall back to env/build vars.
const pusherKey = (window.Laravel && window.Laravel.pusherKey) || process.env.MIX_PUSHER_APP_KEY || process.env.VITE_PUSHER_APP_KEY || '<YOUR_PUSHER_KEY>';
const pusherCluster = (window.Laravel && window.Laravel.pusherCluster) || process.env.MIX_PUSHER_APP_CLUSTER || process.env.VITE_PUSHER_APP_CLUSTER || '<YOUR_CLUSTER>';

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: pusherKey,
    cluster: pusherCluster,
    forceTLS: true,
    encrypted: true,
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    disabledTransports: ['sockjs', 'xhr_polling'],
});

// Listen for new messages on private channel
// Subscribe to the authenticated user's private channel (notifications)
if (window.currentUserId) {
    try {
        window.Echo.private(`App.Models.User.${window.currentUserId}`)
            .notification((payload) => {
                const event = new CustomEvent('notification-received', { detail: payload });
                window.dispatchEvent(event);
            })
            .listen('.MessageSent', (e) => {
                // Emit a custom event or directly update UI
                const event = new CustomEvent('message-received', { detail: e });
                window.dispatchEvent(event);
            });
    } catch (e) {
        console.warn('Echo private user subscription failed', e);
    }
}

// Public channels for realtime updates (courses/modules)
try {
    window.Echo.channel('courses')
        .listen('CourseCreated', (e) => {
            window.dispatchEvent(new CustomEvent('course-created', { detail: e }));
        });

    window.Echo.channel('modules')
        .listen('ModuleCreated', (e) => {
            window.dispatchEvent(new CustomEvent('module-created', { detail: e }));
        });

    // If this page exposes a module or course id, join presence channels to show live editors
    try {
        const moduleId = window.currentModuleId || null;
        const courseId = window.currentCourseId || null;

        if (moduleId && window.Echo.join) {
            window.Echo.join(`module.${moduleId}`)
                .here(users => window.dispatchEvent(new CustomEvent('module-presence-here', { detail: users })))
                .joining(user => window.dispatchEvent(new CustomEvent('module-presence-join', { detail: user })))
                .leaving(user => window.dispatchEvent(new CustomEvent('module-presence-leave', { detail: user })));
        }

        if (courseId && window.Echo.join) {
            window.Echo.join(`course.${courseId}`)
                .here(users => window.dispatchEvent(new CustomEvent('course-presence-here', { detail: users })))
                .joining(user => window.dispatchEvent(new CustomEvent('course-presence-join', { detail: user })))
                .leaving(user => window.dispatchEvent(new CustomEvent('course-presence-leave', { detail: user })));
        }
    } catch (err) {
        console.debug('presence channel setup failed', err);
    }
} catch (err) {
    // Echo may not be fully configured in local/dev; silently ignore
}
