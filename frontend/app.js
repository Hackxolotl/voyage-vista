const e = React.createElement;

function App() {

  const [destinations, setDestinations] = React.useState([]);

  React.useEffect(() => {

    fetch(`${API_URL}/api/destinations.php`)
      .then(res => res.json())
      .then(data => setDestinations(data));

  }, []);

  return e(
    "div",
    { className: "container" },

    e("h1", null, "VoyageVista"),

    destinations.map(d =>

      e(
        "div",
        {
          key: d.id,
          className: "card"
        },

        e("h2", null, d.name),
        e("p", null, d.description),
        e("strong", null, d.price + " €")
      )
    )
  );
}

const root = ReactDOM.createRoot(
  document.getElementById("root")
);

root.render(e(App));
