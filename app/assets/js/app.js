import React from 'react';
import ReactDOM from 'react-dom';
import DeliveryTable from "./components/DeliveryTable";
import DeliveryContextProvider from "./contexts/DeliveryContext";

class App extends React.Component {
    render() {
        return (
            <div>
                <DeliveryContextProvider>
                    <DeliveryTable/>
                </DeliveryContextProvider>
            </div>
        );
    }
}

ReactDOM.render(<App/>, document.getElementById('root'));