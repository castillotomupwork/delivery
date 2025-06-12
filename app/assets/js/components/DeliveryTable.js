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

import Backdrop from '@material-ui/core/Backdrop';

import CircularProgress from '@material-ui/core/CircularProgress';

function DeliveryTable() {
    const context = useContext(DeliveryContext);
    const [tabValue, setTabValue] = React.useState('0');
    const [inputs, setInputs] = useState({});
    const [loading, setLoading] = useState(false);
    const [loadingEstimate, setLoadingEstimate] = useState(false);
    const [loadingBook, setLoadingBook] = useState(false);

    const handleChange = (event) => {
        const name = event.target.name;
        const value = event.target.value;
        setInputs(values => ({...values, [name]: value}));
    }

    const handleSubmit = async (event) => {
        event.preventDefault();
        
        setLoading(true);

        setLoadingEstimate(true);
        
        try {
            await context.estimateDelivery(event, inputs);
        } catch (err) {
            console.error(err);
        } finally {
            setLoadingEstimate(false);

            setLoading(false);
        }
    };

    const handleTabChange = (event, newValue) => {
        setTabValue(newValue);
    };

    const handleBookSubmit = async (transportId) => {
        setLoading(true);

        setLoadingBook(true);

        try {
            await context.bookDelivery(transportId, inputs);
        } catch (err) {
            console.error(err);
        } finally {
            setLoadingBook(false);

            setLoading(false);
        }

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
                        {context.error_message && (
                            <Typography color="error" align="center" sx={{ mb: 2 }}>
                                {context.error_message}
                            </Typography>
                        )}
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
                            <Button
                                type="submit"
                                variant="outlined"
                                key={'estimate-button'}
                                disabled={loadingEstimate}
                                endIcon={loadingEstimate ? <CircularProgress size={16} /> : null}
                            >
                                {loadingEstimate ? 'Processing...' : 'Estimate Transport'}
                            </Button>
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
                                        <Button 
                                            variant="outlined" 
                                            key={'book-button-' + index}
                                            onClick={() => {handleBookSubmit(deliver.id)}}
                                            disabled={loadingBook}
                                            endIcon={loadingBook ? <CircularProgress size={16} /> : null}
                                        >
                                            {loadingBook ? 'Booking...' : 'Book Delivery'}
                                        </Button>
                                    </Typography>
                                </TabPanel>
                            ))}
                        </TabContext>
                    </Box>

                    <Backdrop open={loading} style={{ zIndex: 9999, color: '#fff' }}>
                        <CircularProgress color="inherit" />
                    </Backdrop>
                </Container>
            </Box>
        </Fragment>
    );
}

export default DeliveryTable;