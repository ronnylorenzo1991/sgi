import Dashboard from '../pages/dashboard/index';
import Home from '../pages/home/index';
import Settings from '../../js/pages/settings/index';
import Roles from '../../js/pages/roles/index';
import Users from '../../js/pages/users/index';
import Events from '../../js/pages/event/index';
import Audits from '../../js/pages/audits/index';

export default [
    {
        path: '/',
        component: Dashboard
    },
    {
        path: '/dashboard',
        component: Dashboard
    },
    {
        path: '/settings',
        component: Settings
    },
    {
        path: '/roles',
        component: Roles
    },
    {
        path: '/users',
        component: Users
    },
    {
        path: '/events',
        component: Events
    },
    {
        path: '/audits',
        component: Audits
    },
];
