FROM node:14-slim
WORKDIR /app

COPY package.json .

RUN yarn install

CMD node index.js
