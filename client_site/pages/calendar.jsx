import { useState } from 'react';

export default function CalendarPage() {
  const [selectedTournament, setSelectedTournament] = useState('');
  const [tournamentResults, setTournamentResults] = useState([]);
  const [showResults, setShowResults] = useState(false);
  const [loading, setLoading] = useState(false);

  const startggURL = "https://api.start.gg/gql/alpha";
  const startggKey = "9142e09aa2b5e4446ba9b13d483c1872";

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
      return data.data.event.id;
    } catch (error) {
      console.error('Error fetching event:', error);
    }
  };

  const getEventStandings = async (eventId, page = 1, perPage = 3) => {
    try {
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
      return data.data.event.standings.nodes;
    } catch (error) {
      console.error('Error fetching standings:', error);
      return [];
    }
  };

  const handleTournamentChange = async (e) => {
    const tournamentSlug = e.target.value;
    setSelectedTournament(tournamentSlug);

    if (!tournamentSlug) {
      setShowResults(false);
      return;
    }

    setLoading(true);
    try {
      const eventId = await getEventId(tournamentSlug, 'ultimate-singles');
      if (!eventId) {
        console.error('No event ID found');
        setLoading(false);
        return;
      }
      const standings = await getEventStandings(eventId);
      if (standings && standings.length > 0) {
        setTournamentResults(standings);
      } else {
        setTournamentResults([]);
      }
      setShowResults(true);
    } catch (error) {
      console.error('Error fetching tournament results:', error);
    }
    setLoading(false);
  };

  return (
    <main>
        <h1>URI Gaming Club Calendar</h1>
        <div className="center-col">
          <p className="center">Welcome to the URI Gaming Club Calendar! View our upcoming events!</p>
          <div className="card">
            <div className="iframe-container">
              <iframe 
                src="https://calendar.google.com/calendar/embed?src=c_9ccdde5bfcfcd22d796b1c739696eaf16c5ddffcef45b6beb55b5fb6c8998507%40group.calendar.google.com&ctz=UTC" 
                frameBorder="0" 
                scrolling="no"
                title="URI Gaming Club Calendar"
              ></iframe>
            </div>
          </div>
          <div className="card">
            <h3>Previous Tournament Results</h3>
            <label htmlFor="tournamentSelect">Select a tournament:</label>
            <select id="tournamentSelect" value={selectedTournament} onChange={handleTournamentChange}>
              <option value="">-- Choose a tournament --</option>
              <option value="uri-rhody-rumble-75">URI Rhody Rumble 75</option>
              <option value="uri-rhody-rumble-74">URI Rhody Rumble 74</option>
              <option value="uri-rhody-rumble-73">URI Rhody Rumble 73</option>
              <option value="uri-rhody-rumble-72">URI Rhody Rumble 72</option>
              <option value="uri-rhody-rumble-71">URI Rhody Rumble 71</option>
              <option value="uri-rhody-rumble-70">URI Rhody Rumble 70</option>
              <option value="uri-rhody-rumble-69">URI Rhody Rumble 69</option>
              <option value="uri-rhody-rumble-68">URI Rhody Rumble 68</option>
              <option value="uri-rhody-rumble-67">URI Rhody Rumble 67</option>
              <option value="uri-rhody-rumble-66-1">URI Rhody Rumble 66</option>
              <option value="uri-rhody-rumble-65">URI Rhody Rumble 65</option>
              <option value="uri-rhody-rumble-64">URI Rhody Rumble 64</option>
              <option value="uri-rhody-rumble-63">URI Rhody Rumble 63</option>
              <option value="uri-rhody-rumble-62">URI Rhody Rumble 62</option>
              <option value="uri-rhody-rumble-61">URI Rhody Rumble 61</option>
            </select>
            {loading && <p>Loading results...</p>}
            {showResults && (
              <ul id="tournamentResults">
                {tournamentResults.length > 0 ? (
                  tournamentResults.map((player, index) => (
                    <li key={index}>
                      {player.placement}. {player.entrant.name}
                    </li>
                  ))
                ) : (
                  <li>No results yet</li>
                )}
              </ul>
            )}
          </div>
        </div>
      </main>
  );
}