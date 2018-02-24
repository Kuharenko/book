'use strict';


const Foo = { template: '<div>foo</div>' }
const Bar = { template: '<div>bar</div>' }

const routes = [
    { path: '/foo', component: Foo },
    { path: '/bar', component: Bar }
]


const router = new VueRouter({
    routes // сокращение от `routes: routes`
})


const app = new Vue({
    router
}).$mount('#app')


const vm = new Vue({
    el: '#app2',
    data: {
        message: "Материалы",
        posts: []
    },
    mounted() {
        var myHeaders = new Headers({
            "Content-Type": "application/json"
        });
        var that = this;
        fetch('http://api.book.my/posts', {'mode': 'cors','headers': myHeaders})
            .then(function(response) {
                return response.json();
            })
            .then(function(json) {
                that.posts = json;
            })
            .catch(function(error) {
                console.log('Request failed', error)
            });
     }
});

