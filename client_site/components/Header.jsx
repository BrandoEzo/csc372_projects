//a header component with site name and logo to be used on all pages
export default function Header() {
  return (
    <header className="hero">
      <div className="container header-content">
        
        <div className="hero-text-content">
          <p className="eyebrow">URI Gaming Club Website</p>
          <p className="hero-text">
            Explore gaming events, learn more about our club, and join our community!
          </p>
        </div>

        <img 
          className="logo" 
          src="/images/logo.png" 
          alt="URI Gaming Club Logo" 
        />

      </div>
    </header>
  );
}