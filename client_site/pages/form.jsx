import { useState } from 'react';
import '../css/style.css';

export default function Form() {
  // Form data state
  const [formData, setFormData] = useState({
    fname: '',
    lname: '',
    age: '',
    email: '',
    student: '',
    event: [],
    hear: '',
  });

  // Error messages state
  const [errorMsgs, setErrorMsgs] = useState({
    fname: '',
    lname: '',
    age: '',
    email: '',
    student: '',
    event: '',
    hear: '',
  });

  // Success/error message state
  const [message, setMessage] = useState('');
  const [feedbackMessage, setFeedbackMessage] = useState('');
  const [removeEmail, setRemoveEmail] = useState('');

  // Validation functions
  const checkName = (name) => name && name.length >= 2 && name.length <= 50;
  const checkAge = (age) => {
    const ageNum = parseInt(age);
    return age && !isNaN(ageNum) && ageNum >= 10 && ageNum <= 120;
  };
  const checkYesNo = (response) => response === 'Yes' || response === 'No';
  const checkText = (text) => text && text.length >= 2 && text.length <= 100;

  // Handle input changes
  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
    // Clear error when user starts typing
    if (errorMsgs[name]) {
      setErrorMsgs(prev => ({
        ...prev,
        [name]: ''
      }));
    }
  };

  // Handle checkbox changes for events
  const handleCheckboxChange = (e) => {
    const { value, checked } = e.target;
    setFormData(prev => {
      const events = checked
        ? [...prev.event, value]
        : prev.event.filter(event => event !== value);
      return {
        ...prev,
        event: events
      };
    });
  };

  // Handle form submission
  const handleSubmit = (e) => {
    e.preventDefault();
    const newErrors = { ...errorMsgs };

    // Validate all fields
    if (!checkName(formData.fname)) {
      newErrors.fname = 'First name must be between 2 and 50 characters.';
    }
    if (!checkName(formData.lname)) {
      newErrors.lname = 'Last name must be between 2 and 50 characters.';
    }
    if (!checkAge(formData.age)) {
      newErrors.age = 'Age must be a number between 10 and 120.';
    }
    if (!checkName(formData.email)) {
      newErrors.email = 'Email must be between 2 and 50 characters.';
    }
    if (!checkYesNo(formData.student)) {
      newErrors.student = 'Please select whether you are a URI student.';
    }
    if (!checkText(formData.hear)) {
      newErrors.hear = 'Response must be between 2 and 100 characters.';
    }

    const allErrors = Object.values(newErrors).filter(err => err).join(' ');

    if (!allErrors) {
      setMessage('Thank you for your submission!');
      // Here you would typically send data to backend/database
      // For now, we'll just show the success message
    } else {
      setMessage('Please correct the following errors: ' + allErrors);
    }
    setErrorMsgs(newErrors);
  };

  // Handle clear session
  const handleClearSession = () => {
    setFormData({
      fname: '',
      lname: '',
      age: '',
      email: '',
      student: '',
      event: [],
      hear: '',
    });
    setMessage('');
    setErrorMsgs({
      fname: '',
      lname: '',
      age: '',
      email: '',
      student: '',
      event: '',
      hear: '',
    });
  };

  // Handle feedback removal
  const handleRemoveFeedback = (e) => {
    e.preventDefault();
    if (removeEmail) {
      // Here you would typically send request to backend to remove feedback
      setFeedbackMessage('Your feedback has been removed!');
      setRemoveEmail('');
    } else {
      setFeedbackMessage('Please enter an email address.');
    }
  };

  return (
    <main className="main-content">
        <div className="container">
          <h1>URI Gaming Club Feedback Form</h1>
          <p className="center">We'd love to hear your thoughts about our club! Please fill out the form below:</p>
          
          <div className="left-col">
            {/* Feedback Form Card */}
            <div className="card">
              <div className={message ? 'special' : 'card'}>
                <h2>{message || 'Feedback Form'}</h2>
              </div>

              <form onSubmit={handleSubmit}>
                <div className="form-group">
                  <label htmlFor="fname">First name:</label>
                  <input
                    type="text"
                    id="fname"
                    name="fname"
                    value={formData.fname}
                    onChange={handleInputChange}
                  />
                  {errorMsgs.fname && <span className="error">{errorMsgs.fname}</span>}
                </div>

                <div className="form-group">
                  <label htmlFor="lname">Last name:</label>
                  <input
                    type="text"
                    id="lname"
                    name="lname"
                    value={formData.lname}
                    onChange={handleInputChange}
                  />
                  {errorMsgs.lname && <span className="error">{errorMsgs.lname}</span>}
                </div>

                <div className="form-group">
                  <label htmlFor="age">Age:</label>
                  <input
                    type="number"
                    id="age"
                    name="age"
                    value={formData.age}
                    onChange={handleInputChange}
                  />
                  {errorMsgs.age && <span className="error">{errorMsgs.age}</span>}
                </div>

                <div className="form-group">
                  <label htmlFor="email">Email:</label>
                  <input
                    type="email"
                    id="email"
                    name="email"
                    value={formData.email}
                    onChange={handleInputChange}
                  />
                  {errorMsgs.email && <span className="error">{errorMsgs.email}</span>}
                </div>

                <div className="form-group">
                  <p>Are you currently a URI Student?</p>
                  <div className="radio-group">
                    <input
                      type="radio"
                      id="yes"
                      name="student"
                      value="Yes"
                      checked={formData.student === 'Yes'}
                      onChange={handleInputChange}
                    />
                    <label htmlFor="yes">Yes</label>
                  </div>
                  <div className="radio-group">
                    <input
                      type="radio"
                      id="no"
                      name="student"
                      value="No"
                      checked={formData.student === 'No'}
                      onChange={handleInputChange}
                    />
                    <label htmlFor="no">No</label>
                  </div>
                  {errorMsgs.student && <span className="error">{errorMsgs.student}</span>}
                </div>

                <div className="form-group">
                  <p>What events are you interested in?</p>
                  <div className="checkbox-group">
                    <input
                      type="checkbox"
                      id="tournament"
                      name="event"
                      value="tournament"
                      checked={formData.event.includes('tournament')}
                      onChange={handleCheckboxChange}
                    />
                    <label htmlFor="tournament">Competitive Tournaments (Weekly or Monthly)</label>
                  </div>
                  <div className="checkbox-group">
                    <input
                      type="checkbox"
                      id="gameNight"
                      name="event"
                      value="gameNight"
                      checked={formData.event.includes('gameNight')}
                      onChange={handleCheckboxChange}
                    />
                    <label htmlFor="gameNight">Weekly Game Night</label>
                  </div>
                  <div className="checkbox-group">
                    <input
                      type="checkbox"
                      id="room"
                      name="event"
                      value="room"
                      checked={formData.event.includes('room')}
                      onChange={handleCheckboxChange}
                    />
                    <label htmlFor="room">Just Hanging Out In The Club Room</label>
                  </div>
                  <div className="checkbox-group">
                    <input
                      type="checkbox"
                      id="other"
                      name="event"
                      value="other"
                      checked={formData.event.includes('other')}
                      onChange={handleCheckboxChange}
                    />
                    <label htmlFor="other">Other</label>
                  </div>
                </div>

                <div className="form-group">
                  <label htmlFor="hear">Is there anything else you'd like to see from us?</label>
                  <textarea
                    id="hear"
                    name="hear"
                    value={formData.hear}
                    onChange={handleInputChange}
                  ></textarea>
                  {errorMsgs.hear && <span className="error">{errorMsgs.hear}</span>}
                </div>

                <div className="button-group">
                  <button type="submit" className="submit-btn">Submit</button>
                  <button type="button" className="clear-btn" onClick={handleClearSession}>
                    Clear Session
                  </button>
                </div>
              </form>
            </div>

            {/* Feedback Removal Card */}
            <div className="card">
              <h3>Feedback Removal Request</h3>
              <div className={feedbackMessage ? 'special' : 'card'}>
                <h4>
                  {feedbackMessage ||
                    'If you would like to have your feedback removed from our database, please enter your email address below and click the button:'}
                </h4>
              </div>
              <form onSubmit={handleRemoveFeedback}>
                <input
                  type="email"
                  value={removeEmail}
                  onChange={(e) => setRemoveEmail(e.target.value)}
                  placeholder="Enter your email"
                  required
                />
                <button type="submit" className="submit-btn">Remove Feedback</button>
              </form>
            </div>
          </div>
        </div>
      </main>
  );
}
