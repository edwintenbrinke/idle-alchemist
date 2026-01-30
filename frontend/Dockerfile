FROM node:18-alpine

WORKDIR /app

RUN npm install -g @ionic/cli

COPY package*.json ./
RUN npm install

COPY . .
