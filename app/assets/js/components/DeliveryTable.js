import React, {Fragment, useContext, initialFormData, useState} from 'react';

import PropTypes from 'prop-types';

import {DeliveryContext} from "../contexts/DeliveryContext";

import {
    Box,
    Container,
    Table,
    TableBody,
    TableCell,
    TableRow,
    TextField,
    Typography,
    Button,
    Tab,
} from '@material-ui/core';

import {
    TabContext,
    TabList,
    TabPanel,
} from '@material-ui/lab';

function DeliveryTable() {
    const context = useContext(DeliveryContext);
    const [tabValue, setTabValue] = React.useState('0');
    const [inputs, setInputs] = useState({});

    const handleChange = (event) => {
        const name = event.target.name;
        const value = event.target.value;
        setInputs(values => ({...values, [name]: value}))
    }

    const handleSubmit = (event) => {
        event.preventDefault();
        context.estimateDelivery(event, inputs);
    };

    const handleTabChange = (event, newValue) => {
        setTabValue(newValue);
    };

    const handleBookSubmit = (transportId) => {
        context.bookDelivery(transportId, inputs);

    }

    return(
        <Fragment>
            <Box sx={{
                width: '100%',
                align: 'center',
            }}>
                <Container maxWidth="sm">
                    <Typography variant="h5" align="center">Order</Typography>
                    <br/>
                    <form onSubmit={handleSubmit}>
                        <Table size="small">
                            <TableBody>
                                {context.items.slice().map((item, index) => (
                                    <TableRow key={'item-' + index}>
                                        <TableCell width={130} align="right" style={{verticalAlign: 'top'}}>
                                            <Typography>{item.name}</Typography>
                                        </TableCell>
                                        <TableCell>
                                            <TextField type="text" name={'item[' + item.id + ']'} InputLabelProps={{
                                                shrink: true,
                                            }} fullWidth={true} variant="outlined" onChange={handleChange} />
                                            <Typography variant="overline">minimum weight: {item.minWeight}kg</Typography>
                                            <br/>
                                            <Typography variant="overline">maximum weight: {item.maxWeight}kg</Typography>
                                        </TableCell>
                                    </TableRow>
                                ))}

                                <TableRow>
                                    <TableCell width={130} align="right">
                                        <Typography>Address</Typography>
                                    </TableCell>
                                    <TableCell>
                                        <TextField type="text" name="address" fullWidth={true} variant="outlined"
                                                   onChange={handleChange} />
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell width={130} align="right">
                                        <Typography>Distance</Typography>
                                    </TableCell>
                                    <TableCell>
                                        <TextField type="number" name="distance" InputLabelProps={{
                                            shrink: true,
                                        }} fullWidth={true} variant="outlined" onChange={handleChange} />
                                        <Typography variant="overline">In Kilometers</Typography>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                        <br/>
                        <Typography align="center">
                            <Button type="submit" variant="outlined" key={'estimate-button'}>Estimate Transport</Button>
                        </Typography>
                    </form>
                    <br/>
                    <Box sx={{width: '100%', typography: 'body1'}}>
                        <TabContext value={tabValue}>
                            <Box sx={{borderBottom: 1, borderColor: 'divider'}}>
                                <TabList onChange={handleTabChange} aria-label="lab API tabs example">
                                    {context.delivery.slice().map((deliver, index) => (
                                        <Tab label={deliver.name} value={index + ''} key={'tab-list-' + index} />
                                    ))}
                                </TabList>
                            </Box>
                            {context.delivery.slice().map((deliver, index) => (
                                <TabPanel value={index + ''} key={'tab-panel-' + index}>
                                    <Table>
                                        <TableBody>
                                            <TableRow>
                                                <TableCell>Total Weight</TableCell>
                                                <TableCell>{deliver.total_weight}kg</TableCell>
                                            </TableRow>
                                            <TableRow>
                                                <TableCell>Price</TableCell>
                                                <TableCell>{deliver.price}</TableCell>
                                            </TableRow>
                                        </TableBody>
                                    </Table>
                                    <br />
                                    <Typography align="center">
                                        <Button variant="outlined" key={'book-button-' + index}
                                            onClick={() => {handleBookSubmit(deliver.id)}}>Book Delivery</Button>
                                    </Typography>
                                </TabPanel>
                            ))}
                        </TabContext>
                    </Box>
                </Container>
            </Box>
        </Fragment>
    );
}

export default DeliveryTable;