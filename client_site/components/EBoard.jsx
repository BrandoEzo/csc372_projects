//a reusable component to show current eboard information

export default function EBoard({ boardMembers = [
  { position: 'President', name: 'Jack Henderson' },
  { position: 'Vice President', name: 'Sam Cerullo' },
  { position: 'Treasurer', name: 'Dominick Garbarino' },
  { position: 'Secretary', name: 'Brandon Ezovski' }
] }) {

  return (
    <div className="card">
      <h3>Current E-Board:</h3>
      <ul>
        {boardMembers.map((member, index) => (
          <li key={index}>{member.position}: {member.name}</li>
        ))}
      </ul>
    </div>
  );
}