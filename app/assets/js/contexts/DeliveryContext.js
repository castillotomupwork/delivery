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
            error_message: '',
        };

        this.getItems();
    }

    async getItems() {
        await axios.get('/api/items')
            .then(response => {
                this.setState({
                    items: response.data.items,
                });
            })
            .catch(error => {
                console.error(error);
            });
    }

    async estimateDelivery(event, data) {
        event.preventDefault();
        
        this.setState({
            error_message: '',
        });

        await axios.post('/api/estimate', data)
            .then(response => {
                if (response.data.status == 'success') {
                    let delivery = [...this.state.delivery];
                    delivery.push(response.data.delivery);
                    this.setState({
                        delivery: response.data.delivery,
                    });
                } else {
                    this.setState({
                        error_message: response.data.message,
                    });
                }
            })
            .catch(error => {
                console.error(error);
            });
    }

    async bookDelivery(transportId, data) {
        await axios.post('/api/book/' + transportId, data)
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