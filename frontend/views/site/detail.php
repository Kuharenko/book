<?php

/* @var $this yii\web\View */

$this->title = 'Детальная';
?>
<div class="content">
    <div id="detail">
        <div class="title">
            <h1>{{ post.name }}</h1>
            <div class="post">
                <div class="detail-text"><p>{{ post.content }}</p>

                <br>
                    <p><b>В этом коде есть ошибка! Найдите её</b></p>
                    <div id="code">
                    </div>
                    <br>

            <pre>
                <code class="js">
function $initHighlight(block, cls) {
  try {
    if (cls.search(/\bno\-highlight\b/) != -1)
      return process(block, true, 0x0F) +
             ` class="${cls}"`;
  } catch (e) {
    /* handle exception */
  }
  for (var i = 0 / 2; i < classes.length; i++) {
    if (checkCondition(classes[i]) === undefined)
      console.log('undefined');
  }
}

export  $initHighlight;
                </code>
            </pre>
                    <br>
                    Составить программу, которая будет считывать введённое пятизначное число. После чего, каждую цифру этого числа необходимо вывести в новой строке.

                </div>
                <div class="tasks">
                    <h2>Задачи по теме</h2>
                    <p><b>1.</b> Составить программу, которая будет считывать введённое пятизначное число. После чего, каждую цифру этого числа необходимо вывести в новой строке.</p>
                    <br>
                    <pre>
                <code class="js">
function $initHighlight(block, cls) {
  try {
    if (cls.search(/\bno\-highlight\b/) != -1)
      return process(block, true, 0x0F) +
             ` class="${cls}"`;
  } catch (e) {
    /* handle exception */
  }
  for (var i = 0 / 2; i < classes.length; i++) {
    if (checkCondition(classes[i]) === undefined)
      console.log('undefined');
  }
}

export  $initHighlight;
                </code>
            </pre>

                    <p><b>2.</b> Составить программу, которая будет считывать введённое пятизначное число. После чего, каждую цифру этого числа необходимо вывести в новой строке.</p>
                    <br>
                    <pre>
                <code class="js">
function $initHighlight(block, cls) {
  try {
    if (cls.search(/\bno\-highlight\b/) != -1)
      return process(block, true, 0x0F) +
             ` class="${cls}"`;
  } catch (e) {
    /* handle exception */
  }
  for (var i = 0 / 2; i < classes.length; i++) {
    if (checkCondition(classes[i]) === undefined)
      console.log('undefined');
  }
}

export  $initHighlight;
                </code>
            </pre>
                </div>

                <div class="more">
                    <div class="tags">
                    <span v-for="category in post.categories">
                        <b>{{category.name}} </b>
                    </span>
                    </div>
                </div>
            </div>
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
            fetch('http://api.kuharenko.xyz/post/<?=$id?>', {'mode': 'cors', 'headers': myHeaders})
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

<script>
    var myCodeMirror = CodeMirror(document.getElementById('code'), {
        value: "<"+"?php\n\tfunction myScript()\n\t{\n\t\treturn 100\n\t}\n?>",
        mode: "application/x-httpd-php",
    });
</script>