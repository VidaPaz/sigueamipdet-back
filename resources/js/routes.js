import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

const router = new Router({
    routes: [

        {
            path: '*',
            redirect:'/bitacora/iniciar-turno'
        }, {
            path: '/bitacora/iniciar-turno',
            name: 'login',
            component: require('./views/bitacora/Login')

        } , {
            path: '/bitacora',
            name: 'bitacora',
            component: require('./views/bitacora/Index'),
            meta:{
                authorization:true,
            }
        },  {
            path: '/bitacora/outages',
            name: 'outages',
            component: require('./views/bitacora/Outages'),
            meta:{
                authorization:true,
            }
        },  {
            path: '/bitacora/crear-outages',
            name: 'crear_outages',
            component: require('./views/bitacora/CrearOutages'),
            meta:{
                authorization:true,
            }
        },  {
            path: '/bitacora/alarmas',
            name: 'alarmas',
            component: require('./views/bitacora/Alarmas'),
            meta:{
                authorization:true,
            }
        },  {
            path: '/bitacora/performance',
            name: 'performance',
            component: require('./views/bitacora/Performance'),
            meta:{
                authorization:true,
            }
        },  {
            path: '/bitacora/novedades',
            name: 'novedades',
            component: require('./views/bitacora/Novedades'),
            meta:{
                authorization:true,
            }
        },  {
            path: '/bitacora/ventanas-mt',
            name: 'ventasmasmt',
            component: require('./views/bitacora/VentanasMT'),
            meta:{
                authorization:true,
            }

        },
        {
            path: '/bitacora/reporte',
            name: 'reporte',
            component: require('./views/bitacora/Reporte'),
            meta:{
                authorization:true,
            }

        },

    ],
    linkExactActiveClass: '',
    mode: 'history',
    scrollBehavior(){
        return {x:0, y:0}
    }
});

router.beforeEach(function (to, from, next) {
    let token = localStorage.getItem('token');
    let authorization = to.meta.authorization ;

    if (authorization && !token) {
        localStorage.clear();
        location.href='/'
    } else if (token && (to.path === '/bitacora/iniciar-turno')) {
        next('bitacora')
    } else {
        next()
    }

});

export default router;
