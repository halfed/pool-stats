import httpClient from './httpClient';

const END_POINT = '/addScores';


const addScores = (args) => {
  console.log("args");
  console.log(args);
  return httpClient.post(END_POINT, args);
}

export {
  addScores
}
