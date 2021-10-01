import { createStore, applyMiddleware, compose, combineReducers } from "redux"
import thunk from "redux-thunk"

import { reducer as appReducer } from "./app/reducer"
import { reducer as authenReducer } from "./authen/reducer"
import { reducer as businessReducer } from "./businesses/reducer"

const rootReducer = combineReducers({
    app: appReducer,
    authen: authenReducer,
    businesses: businessReducer
})

const enhancer = compose(applyMiddleware(thunk))
export const store = createStore(rootReducer, enhancer)
