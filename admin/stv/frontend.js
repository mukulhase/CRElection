var animDuration = 1800;

function createCandidate(candID, name){
    var D = document.createElement('div');
    D.setAttribute('class','candidate');
    var H = document.createElement('h3');
    H.innerHTML = name;
    D.setAttribute('id',candID);
    D.appendChild(H);
    var D2 = document.createElement('div');
    D2.setAttribute('id',candID.toString() + '_size');
    D2.setAttribute('class','bar');
    D.appendChild(D2);
    document.getElementById('cand_list').appendChild(D);
}


function frontRemove(candID) {
    var r = $.Deferred();
    $('#' + candID.toString()).animate({opacity: "toggle"}, animDuration, "linear", function(){r.resolve();});
    return r;
}

function updateStatus(txt) {
    $('#status').fadeOut(animDuration/2, function() {
        $(this).text(txt).fadeIn(animDuration/2);
    });
}

function graphDataRefresh(){
    var graphLabels=[];
    var graphVotes=[];
    for(i in CandidateMap) {
        graphLabels.push(CandidateMap[i]);
        if (count[i])
            graphVotes.push(parseFloat(count[i].toString()));
        else
            graphVotes.push(parseFloat(t.toString()));
    }
    data = {
        labels: graphLabels,
        datasets: [
            {
                label: "Votes",
                fillColor: "rgba(151,187,205,0.5)",
                strokeColor: "rgba(151,187,205,0.8)",
                highlightFill: "rgba(151,187,205,0.75)",
                highlightStroke: "rgba(151,187,205,1)",
                data: graphVotes
            }
        ]
    };
}

var myChart;
var data;
function fillChart(){
    var graph= document.getElementById("graph").getContext("2d");
    graphDataRefresh();
    myChart = new Chart(graph).Bar(data,{
        barValueSpacing : 50
    });
}
function updateChart(){
    myChart.update();
}
