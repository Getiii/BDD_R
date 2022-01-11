function verifSuppression() {
    let isExecuted = confirm("Are you sure to execute this action?");
    if (isExecuted == false){
        let e = document.getElementById("formDel");
        e.action = "index.php?gestJeux";
    }else
    {
        let e = document.getElementById("formDel");
        e.action = "index.php?supprJeu";
    }
    console.log(isExecuted); // OK = true, Cancel = false
}


function carroussel() {
    var timer = 4000;

    var i = 0;
    var max = $('#c > li').length;

    $("#c > li").eq(i).addClass('active').css('left','0');
    $("#c > li").eq(i + 1).addClass('active').css('left','25%');
    $("#c > li").eq(i + 2).addClass('active').css('left','50%');
    $("#c > li").eq(i + 3).addClass('active').css('left','75%');


    setInterval(function(){

        $("#c > li").removeClass('active');

        $("#c > li").eq(i).css('transition-delay','0.25s');
        $("#c > li").eq(i + 1).css('transition-delay','0.5s');
        $("#c > li").eq(i + 2).css('transition-delay','0.75s');
        $("#c > li").eq(i + 3).css('transition-delay','1s');

        if (i < max-4) {
            i = i+4;
        }

        else {
            i = 0;
        }

        $("#c > li").eq(i).css('left','0').addClass('active').css('transition-delay','1.25s');
        $("#c > li").eq(i + 1).css('left','25%').addClass('active').css('transition-delay','1.5s');
        $("#c > li").eq(i + 2).css('left','50%').addClass('active').css('transition-delay','1.75s');
        $("#c > li").eq(i + 3).css('left','75%').addClass('active').css('transition-delay','2s');

    }, timer);

}