<?php

/* @var $this yii\web\View */

$this->title = 'Детальная';
?>
<div class="content">
    <div id="detail">
        <div class="title">
            <h1>Інкапсуляція</h1>
            <div class="post">
                <div class="detail-text">
                    <p>Нагадаємо визначення класу</p>

                    <pre><code class="c++" id="zero"></code></pre>

<div id="typed-strings">
    <p>
       <code class="cpp hljs"><span class="hljs-class"><span class="hljs-keyword">class</span> <span class="hljs-title">classname</span> {</span>
    <span class="hljs-keyword">private</span>:
        <span class="hljs-comment">// закриті функції та дані</span>
        <span class="hljs-keyword">int</span> somedata;

    <span class="hljs-keyword">public</span>:
        <span class="hljs-comment">// загальнодоступні функції та дані</span>
        <span class="hljs-function"><span class="hljs-keyword">void</span> <span class="hljs-title">setdata</span><span class="hljs-params">(<span class="hljs-keyword">int</span> d )</span> </span>{
            somedata = d;
        }

        <span class="hljs-function"><span class="hljs-keyword">void</span> <span class="hljs-title">showdata</span><span class="hljs-params">()</span> </span>{
            <span class="hljs-built_in">cout</span> &lt;&lt; <span class="hljs-string">"Значення поля рівне"</span> &lt;&lt; somedata &lt;&lt; <span class="hljs-built_in">endl</span>;
        }
};</code>
    </p>

</div>
<span id="typed"></span>
               <script>
  var typed = new Typed('#zero', {
      stringsElement: '#typed-strings',
      typeSpeed: 40,
      showCursor: false
  });
</script>
            </pre>
                    <p>Визначення починається з ключового слова <b>class</b>, за яким слідує ім'я класу;
                        в даному випадку цим ім'ям є classname. Подібно структурі,
                        тіло класу укладено в фігурні дужки, після яких слідує крапка з комою (;).</p>

                    <p>Клас classname містить тольки одне поле даних somedata, що має тип int. Дані, що містяться
                        всередині класу, називають <b>даними-членами</b> або <b>полями класу</b>. Число полів класу, як і у структури,
                        теоретично може бути будь-яким.</p>

                    <p>Методи класу - це функції, що входять до складу класу. Клас classname містить два методи:
                        setdata() і showdata(). </p>

                    <h2>Приховування даних і доступність функцій</h2>
                    <p>Тіло класу містить два ключових слова які не зустрічалися раніше: <b>private</b> і <b>public</b>. Зараз ми розкриємо їх зміст.</p>

                    <p>Ключовою особливістю об'єктно-орієнтованого програмування є можливість <i>приховування даних</i>,
                        також називають <b>інкапсуляцією</b>. Цей термін
                        розуміється в тому сенсі, що дані укладені всередині класу і захищені від несанціонірованного доступу
                        функцій, розташованих поза класом. Якщо необхідно захистити будь-які дані, то їх поміщають всередину
                        класу з ключовим словом <b>private</b>. Такі дані доступні тільки усередині класу. Дані, описані з ключовим
                        словом <b>public</b>, навпаки, доступні за межами класу.</p>
                    <p>Слід зазначити, що існує ще й третій модифікатор доступу <b>protected</b>,
                        який надає доступ класам, що успадкувались від данного. Більш детально цей маркер доступу
                        буде описаний у розділі <a href="#">успадкування</a>.</p>

                    <p>Як правило, приховуючи дані класу, його методи залишають доступними. Це пояснюється тим,
                        що дані приховують з метою уникнення небажаного зовнішнього впливу на них, а фунцкціі,
                        що працюють з цими даними, повинні забезпечувати взаємодію між даними і зовнішньої
                        по відношенню до класу частиною програми. Тим не менш, не існує чіткого правила,
                        яке б визначало, які дані слід визначати як <b>private</b>, а які функції - як <b>public</b>.
                        Ви можете зіткнутися з ситуаціями, коли вам буде необхідно приховувати функції
                        і забезпечувати вільний доступ до даних класу.</p>
                    <p>Визначаючи клас, ми створюємо новий тип даних.
                        На ім'я класу можна посилатися точно так, як на будь-який вбудований тип даних.
                        Можна створювати об'єкти цього нового типу аналогічно тому,
                        як ми створюємо об'єкти вбудованих типів:</p>
                    <pre><code class="c++" id="two"></code></pre>

                    <div id="typed-strings2">
                        <p>
                            <code class="cpp hljs"><span class="hljs-comment">// статичний об'єкт типу classname</span>
classname myObject;
<span class="hljs-comment">// вказівник на динамічний об'єкт типу classname</span>
classname *myObject = <span class="hljs-keyword">new</span> classname;</code>
                        </p>

                    </div>
                    <span id="typed"></span>
                    <script>
                        var typed = new Typed('#two', {
                            stringsElement: '#typed-strings2',
                            typeSpeed: 40,
                            showCursor: false
                        });
                    </script>

                    <p>Приклад</p>
                    <pre>
                        <code class="cpp">// оголошується класс Car використанням ключового слова class
class Car {
    private:
        // закриті функції та дані класу Car
        // рік випуску автомобіля
        int yearOfIssue;

    public:
        // загальнодоступні функції та дані класу Car
        // задати рік випуску автомобіля
        void setYearOfIssue(int year) {
            yearOfIssue = year;
        }
        // отримати рік випуску автомобіля
        int getYearOfIssue() {
            return yearOfIssue;
        }
};

// створюється об'єкт класу Car
Car nissan;

// використовуючі загальнодоступний метод setYearsOfIssue задаємо рік випуску автомобіля
nissan.setYearOfIssue(2018);

// використовуючі загальнодоступний метод getYearOfIssue отримуємо рік випуску автомобіля
nissan.getYearOfIssue();

// звернення до закритих данних виведе помилку
int carYear = nissan.yearOfIssue;</code>
                    </pre>
                    <div class="error">
                    <div class="title">Знайдіть помилку</div>

                    <div id="code-error-1"></div>
                        <script>
                            var source_code = "#include <iostream>\n" +
                                "using namespace std;\n\n" +
                                "int main()\n" +
                                "{\n" +
                                "\tclass Car {\n" +
                                "\t\tprivate:\n" +
                                "\t\t\tint yearOfIssue;\n" +
                                "\n\t\tpublic:\n" +
                                "\t\t\tvoid setYearOfIssue(int year) {\n" +
                                "\t\t\t\tyearOfIssue =  year;\n" +
                                "\t\t\t}\n" +
                                "\t\t\tint getYearOfIssue() {\n" +
                                "\t\t\t\treturn yearOfIssue;\n" +
                                "\t\t\t}\n" +
                                "\t};\n" +
                                "\n" +
                                "\tCar nissan;\n" +
                                "\tnissan.setYearOfIssue();\n" +
                                "\tcout << nissan.getYearOfIssue() << endl;\n" +
                                "\treturn 0;\n" +
                                "}";
                            var myCodeMirror = CodeMirror(document.getElementById('code-error-1'), {
                                value: source_code,
                                lineNumbers: true,
                                mode: "text/x-c++src",
                            });
                        </script>

                    <div class="answer">Перевірити</div>
                        <script>
                            $('.answer').click(function () {
                                $.ajax({
                                    type: "POST",
                                    url: 'http://api.book.my/check-task/2',
                                    data: {"source": myCodeMirror.getValue(), "task_id": 2}, // serializes the form's elements.
                                    success: function(data)
                                    {
                                        $('.overlay').addClass('active'); // show response from the php script.
                                        $('.overlay #modal .title').text('Результат виконання завдання!');
                                        $('.overlay #modal .response').text(data);

                                    }
                                });
                            });
                        </script>
                    </div>



                    <h2>Навіщо приховувати дані?</h2>
                    <p>Приховування даних в нашому тлумаченні означає огорожу даних від тих частин програми, які не
                        мають необхідності використовувати ці дані. У більш вузькому сенсі це означає приховування
                        даних одного класу від іншого класу. Приховування даних дозволяє уберегти досвідчених
                        програмістів від своїх власних помилок. Програмісти можуть самі створити засоби доступу до
                        закритих даних, що значно знижує ймовірність випадкового або некоректного доступу до них.</p>





                    <p>У тих випадках, коли тіла методів невеликі за розміром,
                        має сенс використовувати більш стислу форму їх запису.</p>

                    <p>Оскільки методи setdata() і showdata() описані з ключовим словом <b>public</b>,
                        вони доступні за межами класу classname.</p>



                    <iframe width="100%" height="420" src="https://www.youtube.com/embed/c9eqy3ue-AM?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>


                <!--                End detail text -->


                <div class="tasks">
                    <h2>Перевірте себе</h2>
                    <form name="encapsulation" id="id_0">
                        <input type="hidden" name="task_id" value="1">
                    <p><b>1.</b> Які ключові слова є маркерами доступу до данних та методів класу?</p>
                    <div class="boxes">
                        <input type="checkbox" id="box-1" name="box_1">
                        <label for="box-1">final</label>

                        <input type="checkbox" id="box-2" name="box_2">
                        <label for="box-2">friend</label>

                        <input type="checkbox" id="box-3" name="box_3">
                        <label for="box-3">public</label>

                        <input type="checkbox" id="box-4" name="box_4">
                        <label for="box-4">private</label>
                    </div>


                    <p><b>2.</b> Який маркер доступу визначає загальнодоступні функції та данні?</p>
                    <div class="boxes">
                        <input type="checkbox" id="box-5" name="box_5">
                        <label for="box-5">final</label>

                        <input type="checkbox" id="box-6" name="box_6">
                        <label for="box-6">friend</label>

                        <input type="checkbox" id="box-7" name="box_7">
                        <label for="box-7">public</label>

                        <input type="checkbox" id="box-8" name="box_8">
                        <label for="box-8">private</label>
                    </div>

                    <p><b>3.</b> Який маркер доступу визначає закриті функції та данні?</p>
                    <div class="boxes">
                        <input type="checkbox" id="box-9" name="box_9">
                        <label for="box-9">final</label>

                        <input type="checkbox" id="box-10" name="box_10">
                        <label for="box-10">friend</label>

                        <input type="checkbox" id="box-11" name="box_11">
                        <label for="box-11">public</label>

                        <input type="checkbox" id="box-12" name="box_12">
                        <label for="box-12">private</label>
                    </div>

                    <p><b>4.</b> Як звертатися до захищених данних класу?</p>
                    <div class="boxes">
                        <input type="checkbox" id="box-13" name="box_13">
                        <label for="box-13">За допомогою оператора "крапка"</label>

                        <input type="checkbox" id="box-14" name="box_14">
                        <label for="box-14">Використовуючи загальнодоступні функції класу </label>

                        <input type="checkbox" id="box-15" name="box_15">
                        <label for="box-15">За допомогою оператора "стрілка"</label>
                    </div>

                        <div id="send" class="send_btn">відправити</div>
                        <script>
                            $('#send').click(function () {
                                $.ajax({
                                    type: "POST",
                                    url: 'http://api.book.my/check-task/1',
                                    data: $("#id_0").serialize(), // serializes the form's elements.
                                    success: function(data)
                                    {
                                       $('.overlay').addClass('active'); // show response from the php script.
                                        $('.overlay #modal .title').text('Результат вашого тестування!');
                                        $('.overlay #modal .response').text(data+'%');


                                    }
                                });
                            });
                        </script>
                    </form>
                </div>

                <div class="sources">
                    <h2>Використані джерела</h2>
                    <ol>
                        <li>Р. Лафоре. Объектно-ориентированное программирование в С++. 4-e издание. 220с.</li>
                        <li>С. Прата. - Язык программирования С++ 6-издание. 492с.</li>
                        <li>С. Липпман, Жози Лажойе - Язык программирования С++. Вводный курс. Третье издание. 37c.</li>
                    </ol>
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
    //    var detail = new Vue({
    //        el: '#detail',
    //        data: {
    //            post: []
    //        },
    //        mounted() {
    //            var myHeaders = new Headers({
    //                "Content-Type": "application/json"
    //            });
    //            var that = this;
    //            fetch('http://api.book.my/post/<?//=$id?>//', {'mode': 'cors', 'headers': myHeaders})
    //                .then(function (response) {
    //                    return response.json();
    //                })
    //                .then(function (json) {
    //                    that.post = json;
    //                })
    //                .catch(function (error) {
    //                    console.log('Request failed', error)
    //                });
    //        }
    //    });
</script>

