<?php

/* @var $this yii\web\View */

$this->title = 'Главная';
?>
<div class="content">
    <div id="list">


        <div class="post" v-for="post in posts">
            <h2>{{ post.name }}</h2>
            <div class="announce">{{ post.content }}</div>
            <div class="more">
                <div class="tags">
                    <span v-for="category in post.categories">
                        <b>{{category.name}} </b>
                    </span>
                </div>
                <a :href="/post/ + post.id">подробнее...</a>
            </div>
        </div>
    </div>
</div>

<script>
    const vm = new Vue({
        el: '#list',
        data: {
            posts: []
        },
        mounted() {
            var myHeaders = new Headers({
                "Content-Type": "application/json"
            });
            var that = this;
            fetch('http://backend.kuharenko.xyz/posts', {'mode': 'cors', 'headers': myHeaders})
                .then(function (response) {
                    return response.json();
                })
                .then(function (json) {
                    that.posts = json;
                })
                .catch(function (error) {
                    console.log('Request failed', error)
                });
        }
    });
</script>