import React, { lazy, Suspense } from "react"
import { BrowserRouter, Switch, Route } from "react-router-dom"

import { PATH } from "../constants/paths"
import Loading from "../components/Loading/Loading"

const FloorPlan = lazy(() => import("../pages/FloorPlan/FloorPlan"))
const Area = lazy(() => import("../pages/Area/Area"))
const Home = lazy(() => import("../pages/Home/Home"))
const Login = lazy(() => import("../pages/Login/Login"))
const NotFound = lazy(() => import("../pages/NotFound/NotFound"))
const Learn = lazy(() => import("../pages/Learn"))

class Routes extends React.Component {
    render() {
        return (
            <Suspense fallback={<Loading />}>
                <BrowserRouter basename={PATH.BASE}>
                    <Switch>
                        <Route exact path={PATH.HOME}>
                            <Home />
                        </Route>
                        <Route exact path={PATH.AREA}>
                            <Area />
                        </Route>
                        <Route exact path={PATH.FLOOR_PLAN}>
                            <FloorPlan />
                        </Route>
                        <Route exact path={PATH.LOGIN}>
                            <Login />
                        </Route>
                        <Route exact path="/learn">
                            <Learn />
                        </Route>
                        <Route path="*">
                            <NotFound />
                        </Route>
                    </Switch>
                </BrowserRouter>
            </Suspense>
        );
    }
}

export default Routes;
