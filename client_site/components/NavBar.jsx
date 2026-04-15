//a navigation bar to be used on all pages
import { NavLink } from "react-router-dom";


export default function NavBar() {
  return (
    <nav className="nav-bar">
      <div className="container nav-links">
        <NavLink to="/" className={({ isActive }) => isActive ? 'nav-link active' : 'nav-link'} end>Home</NavLink>
        <NavLink to="/events" className={({ isActive }) => isActive ? 'nav-link active' : 'nav-link'} end>Events</NavLink>
        <NavLink to="/form" className={({ isActive }) => isActive ? 'nav-link active' : 'nav-link'} end>Feedback</NavLink>
        <NavLink to="/calendar" className={({ isActive }) => isActive ? 'nav-link active' : 'nav-link'} end>Calendar</NavLink>
      </div>
    </nav>
  );
}