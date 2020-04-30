<?php include 'includes/header.php'
?>
<link href = 'Fragenseitendesign.css' rel = 'stylesheet'>


<section class = 'welcome'>
<h1>Willkommen auf der Fragenseite!</h1>
<p>Some subtitle message</p>
</section>
<section class = 'questions'>
<p class = 'abc'>Anzeige Frage 1 von X</p>
<input class = 'def' type = 'text' value = 'Frage X'>
<div class = 'question-wrapper'>

<input class = 'rating'  >

</div>
<div class = 'actions'>
<button id = 'back-btn' class = 'hidden'>Zurück!</button>
<button id = 'continue-btn'>Nächste Frage</button>
</div>
</section>
<script src = './Fragenseite.index.js'></script>
</body>
</html>


<style>

/* Sternebewertung */

span#Bewertung {
 line-height: 45px;
}

span.sternebewertung {
 float: Left;
}

span.sternebewertung:not(:checked) > input {
 display: None;
}

span.sternebewertung:not(:checked) > label {
 float: Right;
 width: 1em;
 padding: 0 .1em;
 overflow: Hidden;
 white-space: Nowrap;
 cursor: Pointer;
 font-size: 200%;
 line-height: 1.2;
 color: #D0D0D0;
 text-shadow: 1px 1px #B0B0B0, 2px 2px #606060, .1em .1em .2em rgba(0,0,0,.5);
 transition: all .5s;
}

span.sternebewertung:not(:checked) > label:before {
 content: '★ ';
}

span.sternebewertung > input:checked ~ label {
 color: #FFD700;
 text-shadow: 1px 1px #C06000, 2px 2px #904000, .1em .1em .2em rgba(0,0,0,.5);
}

span.sternebewertung:not(:checked) > label:hover,
span.sternebewertung:not(:checked) > label:hover ~ label {
 color: #FFD700;
 text-shadow: 1px 1px #F29E02, 2px 2px #B57340, .1em .1em .2em rgba(0,0,0,.5);
}

span.sternebewertung > input:checked + label:hover,
span.sternebewertung > input:checked + label:hover ~ label,
span.sternebewertung > input:checked ~ label:hover,
span.sternebewertung > input:checked ~ label:hover ~ label,
span.sternebewertung > label:hover ~ input:checked ~ label {
 color: #F9B500;
 text-shadow: 1px 1px #F8BA01, 2px 2px #B57340, .1em .1em .2em rgba(0,0,0,.5);
}
</style>

<p>
<span class="sternebewertung">
 <input type="radio" id="stern5" name="bewertung" value="5"><label for="stern5" title="5 Sterne">5 Sterne</label>
 <input type="radio" id="stern4" name="bewertung" value="4"><label for="stern4" title="4 Sterne">4 Sterne</label>
 <input type="radio" id="stern3" name="bewertung" value="3"><label for="stern3" title="3 Sterne">3 Sterne</label>
 <input type="radio" id="stern2" name="bewertung" value="2"><label for="stern2" title="2 Sterne">2 Sterne</label>
 <input type="radio" id="stern1" name="bewertung" value="1"><label for="stern1" title="1 Stern">1 Stern</label>
 <span id="Bewertung"><label>Bewertung:</label></span>
</span>
</p>

