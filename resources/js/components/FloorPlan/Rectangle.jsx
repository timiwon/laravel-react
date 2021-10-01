import React from "react";

const Rectangle = () => {
  const [position, setPosition] = React.useState({
    x: 200,
    y: 180,
    active: false,
    offset: { }
  });

  const handlePointerDown = e => {
    const el = e.target;
    const bbox = e.target.getBoundingClientRect();
    const x = e.clientX - bbox.left;
    const y = e.clientY - bbox.top;
    el.setPointerCapture(e.pointerId);
    setPosition({
      ...position,
      active: true,
      offset: {
        x,
        y
      }
    });
  };
  const handlePointerMove = e => {
    const bbox = e.target.getBoundingClientRect();
    const x = e.clientX - bbox.left;
    const y = e.clientY - bbox.top;
    if (position.active) {
      setPosition({
        ...position,
        x: position.x - (position.offset.x - x),
        y: position.y - (position.offset.y - y)
      });
    }
  };
  const handlePointerUp = e => {
    setPosition({
      ...position,
      active: false
    });
  };

  return (
      <g
        onPointerDown={handlePointerDown}
        onPointerUp={handlePointerUp}
        onPointerMove={handlePointerMove}
        fill={position.active ? "#389e0d" : "#874d00"}>
          <circle
              cx={position.x - 15}
              cy={position.y - 15}
              r={8}
          />
          <circle
              cx={position.x + 15}
              cy={position.y - 15}
              r={8}
          />
          <circle
              cx={position.x - 15}
              cy={position.y + 15}
              r={8}
          />
          <circle
              cx={position.x + 15}
              cy={position.y + 15}
              r={8}
          />
          <rect
              x={position.x - 17}
              y={position.y - 17}
              width={35}
              height={35}
              stroke="black"
          />
          <text
              x={position.x}
              y={position.y}
              text-anchor="middle"
              stroke="#fff" stroke-width="1px"
              dy=".3em">3</text>
      </g>
  );
};

export default Rectangle
