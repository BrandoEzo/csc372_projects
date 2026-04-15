import Header from '../components/Header.jsx';
import NavBar from '../components/NavBar.jsx';
import Footer from '../components/Footer.jsx';

/*
  TO-DO:
  1. Import Routes and Route from react-router-dom

  2. Import all pages:
     
  3. Add Routes inside <main>
*/
import {Route, Routes} from 'react-router-dom';
import Home from "../pages/homepage.jsx";
import Events from "../pages/events.jsx";
import Feedback from "../pages/form.jsx";
import Calendar from "../pages/calendar.jsx";
import NotFound from "../pages/notFound.jsx"

export default function App() {
  return (
    <div className="site-shell">
      <Header />
      <NavBar />

      <main className="page-content container">
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/events" element={<Events/>} />
          <Route path="/form" element={<Feedback/>} />
          <Route path="/calendar" element={<Calendar/>} />
          <Route path="*" element={<NotFound />} />
        </Routes>
      </main>

      <Footer />
    </div>
  );
}