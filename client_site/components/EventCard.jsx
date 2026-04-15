//a reusable component for the event cards on the events page

export default function EventCard({ title, description, details, category }) {
  return (
    <div className="card">
      {category && <p className="event-category">{category}</p>}
      <h3>{title}</h3>
      <p>{description}</p>
      <ul>
        {details.map((detail, index) => (
          <li key={index}>
            {detail.nested ? (
              <>
                {detail.text}
                <ul>
                  {detail.nested.map((nestedItem, nestedIndex) => (
                    <li key={nestedIndex}>{nestedItem}</li>
                  ))}
                </ul>
              </>
            ) : (
              detail.text
            )}
          </li>
        ))}
      </ul>
    </div>
  );
}