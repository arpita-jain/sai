$(function(){
    // for sample 1
    $('#cropbox1').Jcrop({ // we linking Jcrop to our image with id=cropbox1
        aspectRatio: 0,
        onChange: updateCoords,
        onSelect: updateCoords
    });

    // for sample 2
    var api = $.Jcrop('#cropbox2',{ // we linking Jcrop to our image with id=cropbox1
        setSelect: [ 100, 100, 200, 200 ]
    });
    var i, ac;

    // A handler to kill the action
    function nothing(e) {
        e.stopPropagation();
        e.preventDefault();
        return false;
    };

    // Returns event handler for animation callback
    function anim_handler(ac) {
        return function(e) {
            api.animateTo(ac);
            return nothing(e);
        };
    };

    // Setup sample coordinates for animation
    var ac = {
        anim1: [0,0,40,600],
        anim2: [115,100,210,215],
        anim3: [80,10,760,585],
        anim4: [105,215,665,575],
        anim5: [495,150,570,235]
    };

    // Attach respective event handlers
    for(i in ac) jQuery('#'+i).click(anim_handler(ac[i]));

    // for sample 3
    $('#cropbox3').Jcrop({ // we linking Jcrop to our image with id=cropbox3
        setSelect: [ 20, 130, 480, 230 ],
        addClass: 'jcrop_custom',
        bgColor: 'blue',
        bgOpacity: .5,
        sideHandles: false,
        minSize: [ 50, 50 ]
    });
});

function updateCoords(c) {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);

    $('#x2').val(c.x2);
    $('#y2').val(c.y2);


    var rx = 200 / c.w; // 200 - preview box size
    var ry = 200 / c.h;

    $('#preview').css({
        width: Math.round(rx * 800) + 'px',
        height: Math.round(ry * 600) + 'px',
        marginLeft: '-' + Math.round(rx * c.x) + 'px',
        marginTop: '-' + Math.round(ry * c.y) + 'px'
    });
};

jQuery(window).load(function(){
    $("#accordion").accordion({autoHeight: false,navigation: true});
});

function checkCoords() {
    if (parseInt($('#w').val())) return true;
    alert('Please select a crop region then press submit.');
    return false;
};