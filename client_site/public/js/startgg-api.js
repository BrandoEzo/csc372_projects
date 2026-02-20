/*Brandon Ezovski, 2/13/26: js file to integrate Start.gg API to retrieve URI events published to the site. This will 
the upcoming events section on the calendar page. Followed the Start.gg API Dev Docs as well as a YouTube tutorial
*/
/*This may prove to be more difficult than I intended, I followed a tutorial for this section
 What I am going to end up doing is give users a few options for previous events to view results
 from. This may end up getting expanded upon later*/
const startggURL = "https://api.start.gg/gql/alpha";
const startggKey = "9142e09aa2b5e4446ba9b13d483c1872"; //this will later be acessible from a database and not in the code directly

/* Start.gg API recommends using POST instead of GET as it is less error prone*/

//Function to get the event ID with the tournament and event name. There is no way to search an event so I can't grab all uri events :(
const getEventId = async (tournamentName, eventName) => {
    const eventSlug = `tournament/${tournamentName}/event/${eventName}`;
    try {
        const response = await fetch(startggURL, {
            method: 'POST',
            headers: {
                'content-type': 'application/json',
                'Accept': 'application/json',
                Authorization: 'Bearer ' + startggKey
            },
            body: JSON.stringify({
                query: "query EventQuery($slug:String) {event(slug: $slug) {id name}}",
                variables: {
                    slug: eventSlug
                },
            })
        });
        const data = await response.json();
        console.log(data.data);
        return data.data.event.id;
    } catch (error) {
        console.error('Error fetching event:', error);
    }
}
//function to retrieve event standings, top 3 by default but we can change the parameters later on if we want to show top 8 or something
const getEventStandings = async (eventId, page = 1, perPage = 3) =>{
    try{
        const response = await fetch(startggURL, {
            method: 'POST',
            headers: {
                'content-type': 'application/json',
                'Accept': 'application/json',
                Authorization: 'Bearer ' + startggKey
            },
            body: JSON.stringify({
                query: `query EventStandings($eventId: ID!, $page: Int!, $perPage: Int!) {
                  event(id: $eventId) {
                    id
                    name
                    standings(query: {
                      perPage: $perPage,
                      page: $page
                    }){
                      nodes {
                        placement
                        entrant {
                          id
                          name
                        }
                      }
                    }
                  }
                }`,
                variables: {
                    eventId: eventId,
                    page: page,
                    perPage: perPage
                },
            })
        });
        const data = await response.json();
        console.log(data.data);
        return data.data.event.standings.nodes;
    } catch (error) {
        console.error('Error fetching standings:', error);
    }

    
}

// Initialize tournament dropdown selector
const initTournamentSelector = () => {
    const tournamentSelect = document.getElementById('tournamentSelect');
    
    if (!tournamentSelect) return; // Element doesn't exist on this page
    
    tournamentSelect.addEventListener('change', function() {
        const tournamentSlug = this.value;
        const resultsList = document.getElementById('tournamentResults');
        
        if (!tournamentSlug) {
            resultsList.style.display = 'none';
            return;
        }
        
        getEventId(tournamentSlug, 'ultimate-singles').then(eventId => {
            if (!eventId) {
                console.error('No event ID found');
                return;
            }
            return getEventStandings(eventId);
        }).then(standings => {
            resultsList.innerHTML = '';
            if (standings && standings.length > 0) {
                standings.forEach(player => {
                    const li = document.createElement('li');
                    li.textContent = `${player.placement}. ${player.entrant.name}`;
                    resultsList.appendChild(li);
                });
            } else {
                const li = document.createElement('li');
                li.textContent = 'No results yet';
                resultsList.appendChild(li);
            }
            resultsList.style.display = 'block';
        }).catch(error => {
            console.error('Error fetching tournament results:', error);
        });
    });
};

// Initialize when the page loads
document.addEventListener('DOMContentLoaded', initTournamentSelector);


