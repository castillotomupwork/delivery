import React, {createContext} from 'react';
import axios from "axios";

export const DeliveryContext = createContext();

class DeliveryContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            items: [],
            delivery: [],
            item_delivery: [],
        };

        this.getItems();
    }

    getItems() {
        axios.get('/api/items')
            .then(response => {
                this.setState({
                    items: response.data.items,
                });
            })
            .catch(error => {
                console.error(error);
            });
    }

    estimateDelivery(event, data) {
        event.preventDefault();
        axios.post('/api/estimate', data)
            .then(response => {
                let delivery = [...this.state.delivery];
                delivery.push(response.data.delivery);
                this.setState({
                    delivery: response.data.delivery,
                });
            })
            .catch(error => {
                console.error(error);
            });
    }

    bookDelivery(transportId, data) {
        axios.post('/api/book/' + transportId, data)
            .then(response => {
                this.setState({
                    delivery: [],
                    item_delivery: [],
                });
            })
            .catch(error => {
                console.error(error);
            });
    }

    render() {
        return (
            <DeliveryContext.Provider value={{
                ...this.state,
                estimateDelivery: this.estimateDelivery.bind(this),
                bookDelivery: this.bookDelivery.bind(this),
            }}>
                {this.props.children}
            </DeliveryContext.Provider>
        );
    }
}

export default DeliveryContextProvider;