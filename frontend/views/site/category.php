<?php

/* @var $this yii\web\View */

$this->title = 'Категории';
?>
<div class="content">
    <div id="detail">
        <h1><?=$this->title?></h1>
        <div class="cats">
            <div class="cat" v-for="cat in post"><a :href="/find/+cat.id">{{ cat.name }}</a></div>
        </div>
    </div>
</div>

<script>
    var detail = new Vue({
        el: '#detail',
        data: {
            post: []
        },
        mounted() {
            var myHeaders = new Headers({
                "Content-Type": "application/json"
            });
            var that = this;
            fetch('http://backend.book.my/categories', {'mode': 'cors', 'headers': myHeaders})
                .then(function (response) {
                    return response.json();
                })
                .then(function (json) {
                    that.post = json;
                })
                .catch(function (error) {
                    console.log('Request failed', error)
                });
        }
    });
</script>