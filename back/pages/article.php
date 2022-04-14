<?php
class PageArticle
{
    public function main($article,$chapters)
    {
        $this->head($article,$chapters);


    }
    public function head($article,$chapters)
    {
        $content="
        <!DOCTYPE html>
        
        <html lang=\"en\" prefix=\"og: http://ogp.me/ns#\">
     

        <head itemscope itemtype=\"http://schema.org/WPHeader\">
        
        ".$this->seo()."
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        
        <meta charset=\"UTF - 8\" />
        <script src=\"../../../front/controller/main.js\"></script>
        <script src=\"../../../front/controller/cabinet.js\"></script>
        <script src=\"../../../front/controller/redactor.js\"></script>
        <script src=\"../../../front/controller/my_cours.js\"></script>
        <script src=\"../../../front/controller/show_cours.js\"></script>
        <script src=\"../../../front/controller/subscr_cours.js\"></script>
        <script src=\"../../../front/controller/repeat.js\"></script>
        <script src=\"../../../front/controller/url.js\"></script>
            <script src=\"NicEdit/nicEdit.js\"></script>
        <script src=\"../../../front/view/main.js\"></script>
        <script src=\"../../../front/view/cabinet.js\"></script>
        <script src=\"../../../front/view/my_cours.js\"></script>
        <script src=\"../../../front/view/redactor.js\"></script>
        <script src=\"../../../front/view/show_cours.js\"></script>
        <script src=\"../../../front/view/subscr_cours.js\"></script>
        <script src=\"../../../front/view/repeat.js\"></script>
            <script src=\"front/view/simple_redact.js\"></script>
    
        <script src=\"../../../front/model/user.js\"></script>
        <script src=\"../../../front/model/cours.js\"></script>
        <script src=\"../../../front/model/chapter.js\"></script>
        <script src=\"../../../front/model/article.js\"></script>
        <script src=\"../../../front/model/url.js\"></script>

        <link rel=\"stylesheet\" href=\"../../../front/style/1200/cabinet.css\">
        <link rel=\"stylesheet\" href=\"../../../front/style/1200/main.css\">
        <link rel=\"stylesheet\" href=\"../../../front/style/1200/my_cours.css\">
        <link rel=\"stylesheet\" href=\"../../../front/style/1200/redactor.css\">
        <link rel=\"stylesheet\" href=\"../../../front/style/1200/repeat.css\">
        <link rel=\"stylesheet\" href=\"../../../front/style/1200/subscr_cours.css\">

        <link rel=\"stylesheet\" href=\"../../../front/style/600/cabinet.css\">
        <link rel=\"stylesheet\" href=\"../../../front/style/600/main.css\">
         <link rel=\"stylesheet\" href=\"../../../front/style/600/menu.css\">
        <link rel=\"stylesheet\" href=\"../../../front/style/600/my_cours.css\">
        <link rel=\"stylesheet\" href=\"../../../front/style/600/redactor.css\">
        <link rel=\"stylesheet\" href=\"../../../front/style/600/repeat.css\">
        <link rel=\"stylesheet\" href=\"../../../front/style/600/subscr_cours.css\">

        <link rel=\"stylesheet\" href=\"../../../Katex/katex.min.css\">
        <script src=\"../../../Katex/katex.min.js\"></script>  
        <link rel=\"stylesheet\" href=\"../../../Chem/easychem.css\">
        <script src=\"../../../Chem/easychem.js\"></script>   
        <link rel=\"stylesheet\" href=\"../../../Code/styles/color-brewer.min.css\">
        <script src=\"../../../Code/highlight.min.js\"></script>    
        </head>
        <body>
        <div id='main'>
        ".$this->mainMenu()."
        ".$this->menu($chapters)."
        ".$this->article($article)."
        </div>
        </body>
        ";
        echo $content;
    }
    public function mainMenu()
    {

       $text = "";

        $text .= "<div class='name'>tiwy - сайт для создания курсов и конспектов </div>";
        $text .="<ul  class='main_menu'>";
        $text .="<li  class='main_punkt'><a href='https://lern.tiwy.ru/'>Главная</a></li>";
        $text .="<li  class='main_punkt' onclick='MainController.cabinet()'>Кабинет</li></ul>";

        return $text;


    }
    public function seo()
    {

        $text = '';
        $text .= '<title itemprop="headline">name</title>';
        $text .= '<meta itemprop="description" name="description" content="description">';
        $text .= '<meta itemprop="keywords" name="keywords" content="keyword">';


        $text .= '<meta property="og:type"               content="article" />';
        $text .= '<meta property="og:title"              content="name" />';
        $text .= '<meta property="og:description"        content="description" />';
        $text .= '<meta property="og:image"              content="keyword" />';

        return $text;
    }
    public function menu($chapters)
    {
        $text ="
        <div class=\"hamburger-menu\">
  <input id=\"menu__toggle\" type=\"checkbox\" />
  <label class=\"menu__btn\" for=\"menu__toggle\">
    <span></span>
  </label>
        ";
        $text .="<div class='chapter_list_show'>";
        for ($i=0; $i<count($chapters);$i++) {
            $text .="<div class='chapter_show'><div class='chapter_name_show'>".$chapters[$i]->name."</div></div>";

        if($chapters[$i]->articles!="" && $chapters[$i]->articles!=null)
        {
            for ($j=0; $j<count($chapters[$i]->articles); $j++)
                {
                    $text .="<a href='https://lern.tiwy.ru/back/responze/article.php?action=article_seo&id=".$chapters[$i]->articles[$j]->id."'>";
                    $text .="<div class='article_show'>".$chapters[$i]->articles[$j]->name."</div></a>";
                }

            }


    }
        $text .="</div>";
        return $text;
    }
    public function article($article)
    {
        $text = "<div id='view' class='view'>$article->text</div>";
        $text .="
        <script>
        let view = document.getElementById(\"view\");

        change();
        function change() {
            view.innerHTML = Redactor.parseMd(view.innerHTML);

            // находим элемент, в который будем рендерить формулу
            let formula = document.getElementsByTagName(\"formula\");

// вызываем метод библиотеки для отображения формулы

            for (let i = 0; i < formula.length; i++)
                katex.render(formula[i].innerHTML, formula[i]);

            let chem = document.getElementsByClassName(\"chem\");

            for (let i = 0; i < chem.length; i++) {
                var elem2 = chem[i];
                var ex2 = ChemSys.compile(chem[i].innerHTML);
                chem[i].innerHTML = \"\";
                ChemSys.draw(elem2, ex2);
            }

            var chem_str = document.getElementsByClassName(\"chem_str\");

            for (let i = 0; i < chem_str.length; i++) {
                var elem2 = chem_str[i];
                var ex2 = ChemSys.compile(chem_str[i].innerHTML);
                chem_str[i].innerHTML = ex2.html();

            }
            hljs.highlightAll();
        }
            
        </script>
        ";
        return $text;
    }


}