import httpClient from './httpClient';

const END_POINT = '/hello';


const getAllUsers = () => httpClient.get(END_POINT);

export {
  getAllUsers
}
