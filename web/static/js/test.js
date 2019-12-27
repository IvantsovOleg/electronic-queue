$(document).ready(function () {

    // Shape — суперкласс
    function Shape() {
        this.x = 0;
        this.y = 0;
    }

// метод суперкласса
    Shape.prototype.move = function(x, y) {
        this.x += x;
        this.y += y;
        console.info('Фигура переместилась.');
    };

// Rectangle — подкласс
    function Rectangle() {
        Shape.call(this); // вызываем конструктор суперкласса
    }

// подкласс расширяет суперкласс
    Rectangle.prototype = Object.create(Shape.prototype);
    Rectangle.prototype.constructor = Rectangle;

    var rect = new Rectangle();

    console.log('Является ли rect экземпляром Rectangle? ' + (rect instanceof Rectangle)); // true
    console.log('Является ли rect экземпляром Shape? ' + (rect instanceof Shape)); // true
    rect.move(1, 1); // выведет 'Фигура переместилась.'




    /*function Cat(){
        this.legs = 4;
        this.say = function(){
            return 'meaowww';
        }

    }
    function Bird (){
        this.wings = 2;
        this.fly = true;
    }
    function CatWings(){
        Cat.apply(this);
        Bird.apply(this);
    }
    var jane = new CatWings();
    console.dir(jane);*/





    /*function Parent(name){
        this.name = name||'Adam';
    }
    Parent.prototype.say = function(){
        return this.name;
    };
    function Child (name){
        Parent.apply(this,arguments);
    }
    var kid = new Child('Миша');
    kid.name;

    alert(kid.name);
    typeof kid.say;*/






    /*function Article() {
        this.tags = ['js', 'css'];
    }

    var article = new Article();

    function BlogPost() {
    }

    BlogPost.prototype = article;
    var blog = new BlogPost();

    function StaticPage() {
        Article.call(this);
    }

    var page = new StaticPage();

    *//*alert(article.hasOwnProperty('tags'));
    alert(blog.hasOwnProperty('tags'));
    alert(page.hasOwnProperty('tags'));*//*

    blog.tags.push('html');
    page.tags.push('php');
    alert(article.tags.join(', '));*/



    /* function Parent(name) {
     this.name = name||'Adam';
     }

     Parent.prototype.say = function () {
     return this.name;
     }
     function Child(name) {
     }

     inherit(Child, Parent);

     function inherit(C, P) {
     C.prototype = new P();
     }

     var kid  = new Child();
     //  kid.name = 'Михайлыч';
     kid.say();


     alert(kid.say());*/


})
