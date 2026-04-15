import EventCard from '../components/EventCard';

export default function EventsPage() {
  const weeklyEvents = [
    {
      title: 'URI Rhody Rumble Weekly',
      description: 'The University of Rhode Island Gaming Club\'s premier weekly Super Smash Bros and Rivals of Aether 2 tournament!',
      details: [
        { text: 'Held in the URI Memorial Union, 50 Lower College Rd, Kingston, RI, 02881, USA' },
        { text: 'Room 312A / 360' },
        {
          text: 'Every Friday Night during the school year (Sept-Dec) / (Feb-May)',
          nested: [
            'Ultimate Singles Starts at 6 PM',
            'Rivals of Aether 2 Starts at 6:30 PM'
          ]
        },
        { text: '64 Entrant Cap' }
      ]
    },
    {
      title: 'Weekly Game Night',
      description: 'A new event hosted by Gaming Club to appeal to a more casual audience. Designated times for people to come together and try out some new games they haven\'t played before! Our entire video game and board game selection is available to be played during these events!',
      details: [
        { text: 'Held in the URI Memorial Union, 50 Lower College Rd, Kingston, RI, 02881, USA' },
        { text: 'Room 312A' },
        { text: 'Every Thursday Night during the school year (Sept-Dec) / (Feb-May)' }
      ]
    }
  ];

  const specialEvents = [
    {
      title: 'URI Rhody Ruckus Monthly',
      description: 'The University of Rhode Island Gaming Club\'s (slightly inconsistent) monthly event, featuring Super Smash Bros Ultimate singles and doubles, Rivals of Aether 2, as well as other fighting game side brackets such as Street Fighter 6, Tekken 8, Guilty Gear: Strive, and more!',
      details: [
        { text: 'Held in the URI Memorial Union, 50 Lower College Rd, Kingston, RI, 02881, USA' },
        { text: 'Atrium 1/2 or Rainville Ballroom' },
        {
          text: 'Once a Month Large Scale Events, held on Saturdays',
          nested: [
            'Smash Ultimate Doubles at 12 PM',
            'Rivals of Aether 2 Singles at 2 PM',
            'Ultimate Singles at 4 PM',
            'Rivals of Aether 2 Doubles at 5 PM',
            'Fighting Game Times to be Announced'
          ]
        },
        { text: '96 Entrant Cap' }
      ]
    },
    {
      title: 'Rhody Fest',
      description: 'The URI Gaming Club is featured at URI\'s Rhody Fest, a welcome event designed for Freshman and new URI students to get to know the clubs and activities available on campus. We bring out a handful of video game consoles and typically run a challenge where if you can beat one of our Super Smash Bros players you win a $5 Dunkin Donuts Gift Card! We bring out some casual games too such as Mario Kart and Mario Party.',
      details: [
        { text: 'Held outside the URI Memorial Union, 50 Lower College Rd, Kingston, RI, 02881, USA' },
        { text: 'Held at the start of the school year, typically early September' }
      ]
    },
    {
      title: 'Sugar Rush',
      description: 'The URI Gaming Club takes part in Sugar Rush, the annual Student Affairs event that takes place around the holidays. This event features several clubs and activities, with the Gaming Club bringing out a few different game consoles like Nintendo Switch and Nintendo Wii for students to play while they enjoy copious amounts of free sugary snacks and drinks. A movie is normally played during this event, as well as music by the URI Radio.',
      details: [
        { text: 'Held in the Ram\'s Den of the URI Memorial Union, 50 Lower College Rd, Kingston, RI, 02881, USA' },
        { text: 'End of the Fall Semester, late December' }
      ]
    }
  ];

  return (
    <main>
        <h1>URI Gaming Club Events Page</h1>
        <p className="center">Welcome to the URI Gaming Club Events Page!</p>

        <div className="left-col">
          <h2>Weekly Events</h2>
          {weeklyEvents.map((event, index) => (
            <EventCard
              key={index}
              title={event.title}
              description={event.description}
              details={event.details}
            />
          ))}

          <h2>Special Events</h2>
          {specialEvents.map((event, index) => (
            <EventCard
              key={index}
              title={event.title}
              description={event.description}
              details={event.details}
            />
          ))}
        </div>
      </main>
    );
  }