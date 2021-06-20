// SetUp des Canvas
var canvasElement = document.getElementById("activityOverview");
var width = getContainerWidth();
var height = "300";

canvasElement.setAttribute('width', width);
canvasElement.setAttribute('height', height);

var canvas = canvasElement.getContext("2d");

// Ausgabe Anzahl der abgefragten Elemente
displayRange();

// Anpassung der Ausgabe für die abgefragten Elemente
$("#range").change(function (){
    displayRange();
});

// Initialer Call der Funktion für den Buttontext
changeSubmitMessage($("#activityType option:selected").text(),$("#range").val());

// Absenden des Requests der Anpassung des Canvas
$("#submitActivityRequest").click(function (){
    var selectedType = $("#activityType option:selected").text();
    var range = $("#range").val();
    var productId = selectedType === "Lagerbestand" ? ($("#productSelect option:selected").val()) : "";

    $.ajax({
        data:{
            "type": selectedType,
            "range": range,
            "productId": productId,
        },
        url:'http://localhost/WebundMultimedia/activity/getActivityData',
        success: function(result){
            drawActivity(JSON.parse(result),range);
        }
    });
});

// Anzeigen der Produktauswahl falls Lagerbestand abgefragt wird
$("#activityType").change(function ()
{
    if ($("#activityType option:selected").text() === "Lagerbestand")
    {
        $("#productSelection").css("display","block");
        $.get("http://localhost/WebundMultimedia/activity/getProductOptions",function (data){
            $("#productSelect").html(data);
        });
    }
    else
    {
        $("#productSelection").css("display","none");
    }
});

// Funktion für die Anpassung der Ausgabe mit den neuen Daten
function drawActivity(valueInformation, columns)
{
    canvas.clearRect(0,0,parseInt(width),parseInt(height));

    var columnWidth = getColumnWidth(columns);
    var stepValue = getStepValue(valueInformation, height);

    canvas.font = "20px Arial";
    canvas.strokeStyle = "#72A7A5";
    canvas.beginPath();
    canvas.moveTo(0,height);


    for (var i = 0; i <columns; i++)
    {
        var elementWidth = (i+1)*columnWidth;
        var elementHeight = height - valueInformation[i] * stepValue
        canvas.lineTo(elementWidth, elementHeight);

        console.log(elementHeight,parseInt(height));

        if (elementHeight === 0)
        {
            canvas.strokeText(valueInformation[i], elementWidth, elementHeight + 20);
        }
        else
            {
                canvas.strokeText(valueInformation[i], elementWidth, elementHeight);
            }

    }

    canvas.stroke();
    canvas.closePath();

    canvas.strokeStyle = "rgba(255,255,255,0.2)";

    for (var j = 0; j <columns; j++)
    {
        drawSeperatorLine((j+1)*columnWidth,height);
    }
}

// Event für die Änderung des Button Textes
$(".activityFilters select, .activityFilters input").change(function(){
    changeSubmitMessage($("#activityType option:selected").text(),$("#range").val())
});

// Funktion berechnet die Schrittweite anhand des höchsten Wertes
function getStepValue(valueArray, height)
{
    var highestInt = 0;

    for (var i = 0; i < valueArray.length; i++)
    {
        if (parseInt(valueArray[i]) > parseInt(highestInt))
            highestInt = valueArray[i];
    }

    return height/highestInt;
}

// Funktion gibt die aktuelle Breite des Containers zurück
function getContainerWidth()
{
    return $(".container").css("width");
}

// Funktion gibt die Breite der Hilfslinien zurück
function getColumnWidth(columns)
{
    return parseInt(width)/columns;
}

// Funktion zeichnet die Hilfslinien
function drawSeperatorLine(columnWitdh,height)
{
    canvas.beginPath();
    canvas.moveTo(columnWitdh,0);
    canvas.lineTo(columnWitdh,height);
    canvas.stroke();
    canvas.closePath();
}

// Funktion gibt die gewählte Reichweite wieder
function displayRange()
{
    $("#rangeValue").html($("#range").val());
}

// Funktion ändert den Text des Submit Buttons
function changeSubmitMessage(type, range)
{
    var text = "";

    switch (type)
    {
        case "Lagerbestand":
            text = "Zeige die Lagerauslastung aus den letzten " + range + " Bestellungen.";
            break;
        case "Bestellung pro Tag":
            text = "Zeige die Anzahl der bestellten Artikel der letzten " + range + " Tage.";
            break;
        case "Produkte pro Bestellung":
            text = "Zeige, wie viele Artikel in den letzten " + range + " Bestellungen bestellt wurden.";
    }

    $("#submitActivityRequest").html(text);
}