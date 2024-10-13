import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link } from '@inertiajs/react';
import axios from 'axios';
import { useState } from 'react';

export default function Search({ message }) {
    const [searchPhrase, setSearchPhrase] = useState('');

    const [searchData, setSearchData] = useState({
        isSearching: false,
        result: {},
        error: {
            isError: false,
            message: '',
        },
    });

    const search = (e) => {
        e.preventDefault();

        setSearchData({
            isSearching: true,
            result: {},
            error: {
                isError: false,
                message: '',
            },
        });

        axios
            .get(route('search-status'), {
                params: {
                    nid: searchPhrase,
                },
            })
            .then(({ data }) => {
                setSearchData({
                    isSearching: false,
                    result: {
                        status: data.status,
                        date: data.date,
                    },
                    error: {
                        isError: false,
                        message: '',
                    },
                });
            })
            .catch(({ response }) => {
                if (response.data.error) {
                    setSearchData({
                        isSearching: false,
                        result: {
                            status: 'Not registered',
                        },
                        error: {
                            isError: true,
                            message: response.data.error,
                        },
                    });
                }
            });
    }

    return (
        <GuestLayout>
            <Head title="Search" />

            <h4 className="mb-8 mt-4 text-center text-xl font-semibold leading-tight text-gray-800">
                Search Vaccination Status
            </h4>

            <Search.RegistrationStatusMessage message={message} />

            <form onSubmit={search}>
                <div>
                    <InputLabel htmlFor="nid" value="Your National ID (NID)" />

                    <TextInput
                        id="nid"
                        name="nid"
                        value={searchPhrase}
                        className="mt-1 block w-full"
                        autoComplete="nid"
                        isFocused={true}
                        onChange={(e) => {
                            setSearchData({
                                ...searchData,
                                isSearching: false,
                                result: {},
                                error: {
                                    isError: false,
                                    message: '',
                                },
                            });
                            setSearchPhrase(e.target.value);
                        }}
                        required
                    />
                </div>

                <div className="mt-4 flex items-center justify-end">
                    <PrimaryButton
                        className="ms-4 mb-4"
                        disabled={
                            searchData.isSearching || searchPhrase.length < 10
                        }
                    >
                        Search
                    </PrimaryButton>
                </div>
            </form>

            {searchData.isSearching && (
                <div className="text-center">
                    Searching for {searchPhrase}...
                </div>
            )}

            <Search.DisplayResult
                status={searchData.result.status}
                date={searchData.result.date}
            />
        </GuestLayout>
    );
}

Search.RegistrationStatusMessage = function SearchStatusMessage({ message }) {
    if (!message || message !== 'registered') {
        return <></>
    }

    return (
        <div className="mb-8 text-center text-green-700 bg-green-100 rounded-lg border border-green-300 p-2">
            <p>You have been registered successfully.</p>
            <p>We will send you an email with the details.</p>
        </div>
    );
}

Search.DisplayResult = function SearchStatusMessage({ status, date = '' }) {
    let StatusText = <></>
    if (status === 'Not registered') {
        StatusText = (
            <div>
                <div className="text-red-500">Not registered</div>
                <div className="mt-4">
                    <Link
                        href={route('register')}
                        className="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Register here.
                    </Link>
                </div>
            </div>
        );
    }

    if (status == 'Not scheduled') {
        StatusText = <div className="text-gray-600">Not scheduled</div>
    }

    if (status == 'Scheduled') {
        StatusText = (
            <div>
                <div className="text-gray-600">Scheduled</div>
                <div className="mt-4">
                    Your vaccination is scheduled at
                    <p className="mt-2 font-semibold">{date}</p>
                </div>
            </div>
        );
    }

    if (status == 'Vaccinated') {
        StatusText = <div className="text-green-500">Vaccinated</div>
    }

    return (
        <div className="text-center mb-4">{StatusText}</div>
    );
}
