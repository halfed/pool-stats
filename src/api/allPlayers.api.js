import httpClient from './httpClient';

const END_POINT = '/getAllPlayers';


const getAllPlayers = () => httpClient.get(END_POINT);

export {
  getAllPlayers
}
