const setSliderItemsWidth = (container,width) => {
    const sliderItems = container.querySelectorAll(".slider-item");
    sliderItems.forEach(item => {
        item.style.width = width + "%";
    });
};

const initilizeSlider = (sliderContainer,slidesPerView) => {
    const controls = sliderContainer.nextElementSibling;
    const childrenCount = sliderContainer.childElementCount;
    const sliderItemWidth = 100 / childrenCount;
    setSliderItemsWidth(sliderContainer,sliderItemWidth);
    const mod = childrenCount % slidesPerView;
    const sliderContainerWidth =
        ((childrenCount - mod) / slidesPerView + mod / slidesPerView) * 100 +
        "%";
    sliderContainer.style.width = sliderContainerWidth;
    const maxDistance = childrenCount - slidesPerView;
    let i = 0;

    const leftArrowIcon = controls.firstElementChild.firstElementChild;
    const rightArrowIcon = controls.lastElementChild.firstElementChild;
    if(slidesPerView >= childrenCount){
        rightArrowIcon.classList.add("disabled")
    }

    const controlsHandler = e => {
        if (e.target.tagName !== "ION-ICON") return;

        const arrowDir = e.target.dataset.dir;
        const isMovingRight = arrowDir === "right";

        if (isMovingRight) {
            if (i < maxDistance) {
                i++;
            }
        } else {
            if (i > 0) {
                i--;
            }
        }
        console.log(leftArrowIcon,rightArrowIcon)
        leftArrowIcon.classList.toggle("disabled", i <= 0);
        rightArrowIcon.classList.toggle("disabled", i >= maxDistance);

        sliderContainer.style.transform = `translateX(${
            -1 * i * sliderItemWidth
        }%)`;
    };

    controls.addEventListener("click", controlsHandler);
};

const sliderContainers = document.querySelectorAll(".slider-container");
sliderContainers.forEach(sliderContainer => {
    initilizeSlider(sliderContainer,4);
})
