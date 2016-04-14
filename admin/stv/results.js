var S = Big(B.length);
var t = Big(S).div((N+1)).plus(1).round(0,0);       // equivalent to Math.floor(stuff)..
var count = {};
var Winners = [];   // Stores the winner candidates in order of votes.
var losers = [];   // Stores the winner candidates in order of votes.

function printB() {
    for(var i=0; i<B.length;i++) {
        console.log(B[i]);
    }
}

function initDS() {
    Big.DP = 40;        // The maximum number of decimal places of the results of operations involving division.
    for(i in CandidateMap) {          // Init count to zero
        count[i] = Big(0);
        createCandidate(i,CandidateMap[i]);
    }
    for (var i=0;i<B.length;i++) {      //Initial Counting
        count[B[i][0]] = (count[B[i][0]]).plus(1.0);
    }
}


function NextTopCand(dict) {
    var res = [], val = Big(-1);
    for(i in dict) {
        if ((dict[i]).gte(val)) {
            if (!(dict[i]).eq(val)) {
                res = [];
            }
            val = dict[i];
            res.push(i);                 // Push person with same votes
        }
    }
    return res[Math.floor(Math.random()*res.length)];   // Return random person from those with same no of votes
}

function NextBottomCand(dict) {
    var res = [], val = Big(9999999);
    for(i in dict) {
        if ((dict[i]).lt(val)) {
            res = [];
            res.push(i);
            val = dict[i];
        } else if((dict[i]).eq(val)) {
            res.push(i);                  // Push person with same votes
        }
    }
    return res[Math.floor(Math.random()*res.length)];   // Return random person from those with same no of votes
}


//Function to Transfer votes from Ci, who got k >= t votes, and was qualified to the delegation.
function TransferDown(c, k) {
    var f = (Big(k).sub(t)).div(k);      // Fraction to transfer - The higher the precision, the better it is :)
    for(var i=0; i<B.length;i++) {
        if(B[i][0] == c) {
            B[i].shift();
            if (B[i].length)    // Vote queue becomes empty after last candidate.
                count[B[i][0]] = count[B[i][0]].plus(f);
        }
    }
}


//Function to Transfer votes from 𝕔i, who got least votes in a stage, and was eliminated.
function TransferUp(c) {
    for(var i=0; i<B.length;i++) {
        if(B[i][0] == c) {
            B[i].shift();
            if (B[i].length)    // Vote queue becomes empty after last candidate.
                count[B[i][0]] = count[B[i][0]].plus(1.0);
        }
    }
}

function removeTrace(cand) {
    delete(count[cand]);                    // Remove from count dict
    for(var i=0; i<B.length; i++) {          // Remove his trace from voteQueues
        var ind = B[i].indexOf(parseInt(cand));
        if (ind == -1)
            continue;
        B[i].splice(ind, 1);
    }
}

function Qualify(TopCand) {
    Winners.push(TopCand);
    console.log('Winner:', TopCand);
}

function loser(LastCand) {
    losers.push(LastCand);
    console.log('loser:', LastCand);
    frontRemove(LastCand);
}

function checkReElectionRequired() {
    if (Winners.length != N)        // If winners != Delegations then declare re-election
        alert('Papa says. Do it again !!');
}

function calcResult() {         // Delegation Determination
    var n=0, TopCand, MaxVotes, loop;
    fillChart();

    function iteration(){
        if(n<N){
            TopCand = NextTopCand(count);
            MaxVotes = count[TopCand];
            // updateStatus('Next Candidate is: ', CandidateMap[TopCand], 'with',MaxVotes);
            if( MaxVotes.gte(t)) {
                Qualify(TopCand);
                TransferDown(TopCand, MaxVotes);
                n += 1;
            } else {
                // Get the bottom candidate as Top :P
                TopCand = NextBottomCand(count);
                loser(TopCand);
                TransferUp(TopCand);
            }

            removeTrace(TopCand);
            graphDataRefresh();
            myChart.update();
            console.log("count:",count,"winners:",Winners,"losers",losers);
        }
        else {
            console.log("hi");
            clearInterval(loop);
            for (i in count) {
                loser(i);
            }
        }
    }
    loop=setInterval(iteration,2000);

}
/*
function updateNorm() {
    for( var i in )
}*/

initDS();
function showResult() {
    calcResult();
    document.getElementById('res_btn').remove();
}
