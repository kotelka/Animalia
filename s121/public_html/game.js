const textElement = document.getElementById('game_text')
const explore_btn = document.getElementById('explore')
const shop_btn = document.getElementById('shop')
const boss_btn = document.getElementById('boss')
const attack_btn = document.getElementById('attack')
const potion_btn = document.getElementById('potion')
const run_btn = document.getElementById('run')
const main_div = document.getElementById('main_buttons')
const fight_div = document.getElementById('fight_buttons')
const potion_div = document.getElementById('potion_buttons')
const game_div = document.getElementById('game')
const start_btn = document.getElementById('start')



//var div = document.getElementById("dom-target");
//var myData = div.textContent;

var jsonUserData = $('.js-user-data').data('userData');

//console.log(jsonUserData['id']);

//console.log(jsonUserData['description']);

// enemies i ich base staty
var enemies = ['szczeniak','shibe','bork','piesel the dog'];
var enemies_att = [5,7,2,20];
var enemies_hp = [25,40,10];
var bosses = ['bingus', 'jamnik-parówka']

var bingus_att = 15;
var bingus_hp = 100;

var jamnik_att = 25;
var jamnik_hp = 250;

var enemy_hp = 0;
var enemy_att = 0;
var player_hp = 0;
var player_att = 0;
var enemy = "";

var dialogue = 2;


let state = {}

function start(){
    textElement.innerHTML = "Witaj ziomek, gra sie robi, usiadz pod palmą i napij sie czegos kokosa moze ananasana komary nie gryzą";
    game_div.style.display = (
        game_div.style.display == "none" ? "block" : "none");
    start_btn.style.display = (
        start_btn.style.display == "none" ? "block" : "none");
}

function startIntro(){
    start_btn.style.display = (
        start_btn.style.display == "none" ? "block" : "none");
    document.getElementById('dialogue-box-1').style.display = (
        document.getElementById('dialogue-box-1').style.display == "none" ? "block" : "none");
}

function next() {
    if (dialogue < 13) {
        document.getElementById('dialogue-box-' + (dialogue - 1)).style.display = (
            document.getElementById('dialogue-box-' + (dialogue - 1)).style.display == "none" ? "block" : "none");
        document.getElementById('dialogue-box-' + dialogue).style.display = (
            document.getElementById('dialogue-box-' + dialogue).style.display == "none" ? "block" : "none");
        dialogue++;
    } else{
        document.getElementById('dialogue-box-' + (dialogue - 1)).style.display = (
            document.getElementById('dialogue-box-' + (dialogue - 1)).style.display == "none" ? "block" : "none");
        game_div.style.display = (
            game_div.style.display == "none" ? "block" : "none");

        textElement.innerHTML = "Witaj ziomek, gra sie robi, usiadz pod palmą i napij sie czegos kokosa moze ananasana komary nie gryzą";
    }
}

function explore(){
    var status = true;
    var random = Math.floor(Math.random() * enemies.length)
    enemy = enemies[random]; // losuje przeciwnika
    enemy_hp = enemies_hp[random];
    enemy_att = enemies_att[random];
    //player base stats
    player_hp = 50;
    player_att = 5;
    textElement.innerHTML = "O NIE, wygląda na to, że " + enemy + " pojawił się, co robisz?" + "\n" + " Twoje zdrowie to " + player_hp  + "\nZdrowie " + enemy + " to " + enemy_hp;
    main_div.style.display = (
        main_div.style.display == "none" ? "block" : "none");
    fight_div.style.display = (
       fight_div.style.display == "none" ? "block" : "none");

}
function shop(){
    textElement.innerHTML = "tu bedzie shoppik kiedys zaraz potem";
}
function boss(){
    textElement.innerHTML = "a tu boss";
}

function attack(){

    player_hp = player_hp - enemy_att;
    enemy_hp = enemy_hp - player_att;
    textElement.innerHTML = "Zaatakowales, zadałeś " + player_att + " pkt obrażeń. Przeciwnikowi zostało " + enemy_hp + "pkt życia. Przeciwnik zaatakował, zadał "
    + enemy_att + "pkt obrażeń. Zostało ci " + player_hp + "pkt życia" ;



}

function potion(){
    textElement.innerHTML = "napij sie na zdrowie";
    fight_div.style.display = (
        fight_div.style.display == "none" ? "block" : "none");
    potion_div.style.display = (
        potion_div.style.display == "none" ? "block" : "none");
}
function use_weak_potion(){
    player_hp = player_hp + 10;
    textElement.innerHTML = "Ahh, masz teraz " + player_hp + " pkt życia";
}

function use_strong_potion(){
    player_hp = player_hp + 20;
    textElement.innerHTML = "HEEEYHEEAAA, masz teraz " + player_hp + "pkt życia";
}
function return_to_fight(){

    potion_div.style.display = (
        potion_div.style.display == "none" ? "block" : "none");
    fight_div.style.display = (
        fight_div.style.display == "none" ? "block" : "none");
    textElement.innerHTML = "wrociles do walki. Twoje zdrowie to " + player_hp  + "\nZdrowie " + enemy + " to " + enemy_hp;


}



function run(){
    textElement.innerHTML = "lama jestes ze uciekles";
    main_div.style.display = (
        main_div.style.display == "none" ? "block" : "none");
    fight_div.style.display = (
        fight_div.style.display == "none" ? "block" : "none");

}







