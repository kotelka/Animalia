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
const shop_div = document.getElementById('shop')
const game_div = document.getElementById('game')
const start_btn = document.getElementById('start')



//var div = document.getElementById("dom-target");
//var myData = div.textContent;

var jsonUserData = $('.js-user-data').data('userData');




var id = jsonUserData['id']

// enemies i ich base staty
var enemies = ['Szczeniak','Shibe','Bork','Pieseł the Doge'];
var enemies_att = [5,8,4,15];
var enemies_hp = [25,30,80,10];
var bosses = ['Bingus', 'Jamnik-parówka'];
var bosses_hp =[100,200];
var bosses_att =[10,20];

//globalne
var enemy_hp = 0;
var enemy_att = 0;
var player_hp = 0;
var player_att = 0;
var enemy = "";
var chapter = jsonUserData['chapter'];
var permission = 0;
var dialogue = 2;



function start(){
    textElement.innerHTML = "Witaj podróżnyaku, pora na przygodę!";
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

        textElement.innerHTML = "Witaj podróżnyaku, pora na przygodę!";
    }
}

function explore(){
    permission = 0;
    $.post(
        'game_data.php',
        {
            dej: "tak",
            id: id
        },function(result) {
            jsonUserData= JSON.parse(result);

        }
    );
    var random = Math.floor(Math.random() * enemies.length)
    enemy = enemies[random]; // losuje przeciwnika
    enemy_hp = enemies_hp[random] * (parseInt(jsonUserData['level'])+1);
    enemy_att = enemies_att[random] * (parseInt(jsonUserData['level'])+1);
    console.log(jsonUserData['weapon']);
    //player base stats
    player_hp = 50 *(parseInt(jsonUserData['shield'])+1) * (parseInt(jsonUserData['level'])+1) ;
    player_att = 5 * (parseInt(jsonUserData['weapon'])+1) * (parseInt(jsonUserData['level'])+1) ;
    textElement.innerHTML = "O NIE, wygląda na to, że " + enemy + " pojawił się, co robisz?" + "\n" + " Twoje zdrowie to " + player_hp  + ",\nzdrowie " + enemy + " to " + enemy_hp;
    main_div.style.display = (
        main_div.style.display == "none" ? "block" : "none");
    fight_div.style.display = (
       fight_div.style.display == "none" ? "block" : "none");
}
function shop(){
    $.post(
        'game_data.php',
        {
            dej: "tak",
            id: id
        },function(result) {
            jsonUserData= JSON.parse(result);

        }
    );
    textElement.innerHTML = "Zapraszam, wszystko na sprzedaż, masz " + jsonUserData['money'] + " gil";
    main_div.style.display = (
        main_div.style.display == "none" ? "block" : "none");
    shop_div.style.display = (
        shop_div.style.display == "none" ? "block" : "none");
}
function boss(){
    $.post(
        'game_data.php',
        {
            dej: "tak",
            id: id
        },function(result) {
            jsonUserData= JSON.parse(result);

        }
    );
    if(jsonUserData['chapter'] == 0 && jsonUserData['level'] >=5){
        enemy = bosses[0]; // losuje przeciwnika
        enemy_hp = bosses_hp[0] * jsonUserData['level'];
        enemy_att = bosses_att[0] * jsonUserData['level'];
        permission = 1;
    }
    else if(jsonUserData['level'] >= 10 && jsonUserData['chapter'] == 1){
        enemy = bosses[1];
        enemy_hp = bosses_hp[1] *jsonUserData['level'];
        enemy_att = bosses_att[1] * jsonUserData['level'];
        permission = 1;
    } else textElement.innerHTML = "Nie jesteś gotowy, wróć gdy nabędziesz trochę doświadczenia miau";

    if (permission == 1){
        player_hp = 50 * jsonUserData['level'];
        player_att = 5 * jsonUserData['level'];
        textElement.innerHTML = "O NIEEEEEE, wygląda na to, że potężny " + enemy + " pojawił się, co robisz?" + "\n" + " Twoje zdrowie to " + player_hp  + ",\nzdrowie " + enemy + " to " + enemy_hp;
        main_div.style.display = (
            main_div.style.display == "none" ? "block" : "none");
        fight_div.style.display = (
            fight_div.style.display == "none" ? "block" : "none");
    }



}

function attack(){

    player_hp = player_hp - enemy_att;
    enemy_hp = enemy_hp - player_att;
    textElement.innerHTML = "Zaatakowałeś, zadałeś " + player_att + " pkt obrażeń. Przeciwnikowi zostało " + enemy_hp + "pkt życia. Przeciwnik zaatakował, zadał "
    + enemy_att + "pkt obrażeń. Zostało ci " + player_hp + "pkt życia" ;

    if(player_hp < 1){
        textElement.innerHTML = "Niestety, pokonano cię, ale nie poddawaj się, micha kocimiętki i wszystko wróci do normy"
        main_div.style.display = (
            main_div.style.display == "none" ? "block" : "none");
        fight_div.style.display = (
            fight_div.style.display == "none" ? "block" : "none");
    } else if(enemy_hp < 1 && permission == 1){
        textElement.innerHTML = "Gratulacje! Pokonałeś BOSSA, w nagrodę dostajesz 100 pkt doświadczenia i 2000 gil"
        main_div.style.display = (
            main_div.style.display == "none" ? "block" : "none");
        fight_div.style.display = (
            fight_div.style.display == "none" ? "block" : "none");

        $.post(
            'game_data.php',
            {
                exp: 100,
                id: id,
                money: 2000,
                chapter: 1
            }
        );
        if(jsonUserData['exp'] >= 500){
            textElement.innerHTML = "Gratulacje! Pokonałeś BOSSA, w nagrodę dostajesz 100 pkt doświadczenia i 500 gil. Zdobyłeś wystarczająco punktów doświadczenia. Twój level się zwiększył";
            $.post(
                'game_data.php',
                {
                    level: 1,
                    id: id
                }
            );
            $.post(
                'game_data.php',
                {
                    dej: "tak",
                    id: id
                },function(result) {
                    jsonUserData= JSON.parse(result);

                }
            );
        }
        permission = 0;
    }else if(enemy_hp <= 0){
        textElement.innerHTML = "Gratulacje! Pokonałeś przeciwnika, w nagrodę dostajesz 20 pkt doświadczenia i 50 gil"
        main_div.style.display = (
            main_div.style.display == "none" ? "block" : "none");
        fight_div.style.display = (
            fight_div.style.display == "none" ? "block" : "none");

        $.post(
            'game_data.php',
            {
                exp: 20,
                id: id,
                money: 50
            }
        );
        if(jsonUserData['exp'] >= 500){
            textElement.innerHTML = "Gratulacje! Pokonałeś przeciwnika, w nagrodę dostajesz 20 pkt doświadczenia i 10 gil. Zdobyłeś wystarczająco punktów doświadczenia. Twój level się zwiększył";
            $.post(
                'game_data.php',
                {
                    level: 1,
                    id: id
                }
            );
            $.post(
                'game_data.php',
                {
                    dej: "tak",
                    id: id
                },function(result) {
                    jsonUserData= JSON.parse(result);

                }
            );
        }
    }



}

function potion(){
    textElement.innerHTML = "Tutaj możesz się uleczyć";
    fight_div.style.display = (
        fight_div.style.display == "none" ? "block" : "none");
    potion_div.style.display = (
        potion_div.style.display == "none" ? "block" : "none");
}
function use_weak_potion(){
    $.post(
        'game_data.php',
        {
            dej: "tak",
            id: id
        },function(result) {
            jsonUserData= JSON.parse(result);

        }
    );
    if(jsonUserData['low_potion'] > 0) {
        $.post(
            'game_data.php',
            {
                low_potion_use: 1,
                id: id

            }
        );
        player_hp = player_hp + 100;
        textElement.innerHTML = "Ahh, masz teraz " + player_hp + " pkt życia";
    } else textElement.innerHTML = "Nie masz małych mikstur, dokup w sklepie";
}

function use_strong_potion(){
    $.post(
        'game_data.php',
        {
            dej: "tak",
            id: id
        },function(result) {
            jsonUserData= JSON.parse(result);

        }
    );
    if(jsonUserData['high_potion'] > 0) {
        $.post(
            'game_data.php',
            {
                high_potion_use: 1,
                id: id

            }
        );
        player_hp = player_hp + 600;
        textElement.innerHTML = "HEEEYHEEAAA, masz teraz " + player_hp + "pkt życia";
    } else textElement.innerHTML = "Nie masz dużych mikstur, dokup w sklepie";
}
function return_to_fight(){

    potion_div.style.display = (
        potion_div.style.display == "none" ? "block" : "none");
    fight_div.style.display = (
        fight_div.style.display == "none" ? "block" : "none");
    textElement.innerHTML = "Wróciłeś do walki. Twoje zdrowie to " + player_hp  + "\n, zdrowie " + enemy + " to " + enemy_hp + " Co chcesz zrobić?";


}

function return2(){

    shop_div.style.display = (
        shop_div.style.display == "none" ? "block" : "none");
    main_div.style.display = (
        main_div.style.display == "none" ? "block" : "none");
    textElement.innerHTML = "Witaj podróżnyaku, pora na przygodę";


}



function run(){
    permission = 0;
    textElement.innerHTML = enemy + " okazał się być zbyt potężny. Uciekłeś i zregenerowałeś siły.";
    main_div.style.display = (
        main_div.style.display == "none" ? "block" : "none");
    fight_div.style.display = (
        fight_div.style.display == "none" ? "block" : "none");

}

function buy_weapon1(){
    if(jsonUserData['money'] >= 2000) {
        textElement.innerHTML = "Oby ci się przydało";
        $.post(
            'game_data.php',
            {
                money: 2000,
                id: id,
                weapon1: 2

            }
        );
        $.post(
            'game_data.php',
            {
                dej: "tak",
                id: id
            },function(result) {
                jsonUserData= JSON.parse(result);

            }
        );
    }else textElement.innerHTML ="Wróć, kiedy bedzięsz miau pieniądze";

}
function buy_weapon2(){
    if(jsonUserData['money'] >= 4000){
    textElement.innerHTML ="Stałeś się potężniejszy";
    $.post(
        'game_data.php',
        {
            money: 4000,
            id: id,
            weapon2: 3

        }
    );
        $.post(
            'game_data.php',
            {
                dej: "tak",
                id: id
            },function(result) {
                jsonUserData= JSON.parse(result);

            }
        );
}else textElement.innerHTML = "Wróć, kiedy bedzięsz miau pieniądze";

}
function buy_shield1(){
    if(jsonUserData['money'] >= 3000){
    textElement.innerHTML ="Dobry wybór";
    $.post(
        'game_data.php',
        {
            money: 3000,
            id: id,
            shield1: 2

        }
    );
        $.post(
            'game_data.php',
            {
                dej: "tak",
                id: id
            },function(result) {
                jsonUserData= JSON.parse(result);

            }
        );
}else textElement.innerHTML ="Wróć, kiedy bedzięsz miau pieniądze";

}
function buy_shield2(){
    if(jsonUserData['money'] >= 8000){
    textElement.innerHTML ="Niech ci przyniesie szczęście";
    $.post(
        'game_data.php',
        {
            money: 8000,
            id: id,
            shield2: 3

        }
    );
        $.post(
            'game_data.php',
            {
                dej: "tak",
                id: id
            },function(result) {
                jsonUserData= JSON.parse(result);

            }
        );
}else textElement.innerHTML ="Wróć, kiedy bedzięsz miau pieniądze";


}
function buy_potion1(){
    if(jsonUserData['money'] >= 100){
    textElement.innerHTML ="Szerokiej drogi";
    $.post(
        'game_data.php',
        {
            money: 100,
            id: id,
            low_potion: 1

        }
    );
        $.post(
            'game_data.php',
            {
                dej: "tak",
                id: id
            },function(result) {
                jsonUserData= JSON.parse(result);

            }
        );
}else textElement.innerHTML ="Wróć, kiedy bedzięsz miau pieniądze";


}
function buy_potion2(){
    if(jsonUserData['money'] >= 400){
        textElement.innerHTML ="Powodzenia";
        $.post(
            'game_data.php',
            {
                money: 400,
                id: id,
                high_potion: 1

            }
        );
        $.post(
            'game_data.php',
            {
                dej: "tak",
                id: id
            },function(result) {
                jsonUserData= JSON.parse(result);

            }
        );
    }else textElement.innerHTML ="Wróć, kiedy bedzięsz miau pieniądze";

}






/*
jsonUserData = result.replace(/(\r\n|\n|\r)/gm, "");
jsonUserData = jsonUserData.replace(/"/g,"");
jsonUserData = jsonUserData.replace(/{/g,"");
jsonUserData = jsonUserData.replace(/}/g,"");
jsonUserData = jsonUserData.split(",");
var exp = jsonUserData[0].split(":");
console.log(exp[1]);
*/
