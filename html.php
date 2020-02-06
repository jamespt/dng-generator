  <?php
  echo '
  <div class="dng-container">
    <div class="dng-row">
      <div class="dng-column">
        <div class="dng-block">
          <div class="dng-gender">
            <button class="active" data-gender="female">Female</button>
            <button data-gender="male">Male</button>
            <button data-gender="both">Both</button>
          </div>
          <div class="dng-letter">
            <div class="dng-letter-selector">
              <div data-value="a">a</div>
              <div data-value="c">c</div>
              <div data-value="d">d</div>
              <div data-value="e">e</div>
              <div data-value="f">f</div>
              <div data-value="g">g</div>
              <div data-value="h">h</div>
              <div data-value="i">i</div>
              <div data-value="j">j</div>
              <div data-value="k">k</div>
              <div data-value="l">l</div>
              <div data-value="m">m</div>
              <div data-value="n">n</div>
              <div data-value="o">o</div>
              <div data-value="p">p</div>
              <div data-value="q">q</div>
              <div data-value="r">r</div>
              <div data-value="s">s</div>
              <div data-value="t">t</div>
              <div data-value="u">u</div>
              <div data-value="v">v</div>
              <div data-value="w">w</div>
              <div data-value="x">x</div>
              <div data-value="y">y</div>
              <div data-value="z">z</div>
              </select>
            </div>
            <h3>Choose by alphabet</h3>
          </div>
        </div>
      </div>
      <div class="dng-column dng-generate-section">
        <div class="dng-block">
          <div>
            <div class="dng-name" data-action="name">
              Loading
            </div>
            <div class="dng-count">
              (Names Generated Today: <span data-action="generated">0</span>)
            </div>

            <div class="dng-share">
              <div class="dng-share-title">SOCIALS</div>
              <div class="dng-share-links">
                <a data-action="social-facebook"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-square" class="svg-inline--fa fa-facebook-square fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path fill="currentColor" d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"></path>
                  </svg></a>
                <a data-action="social-twitter"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter-square" class="svg-inline--fa fa-twitter-square fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path fill="currentColor" d="M400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zm-48.9 158.8c.2 2.8.2 5.7.2 8.5 0 86.7-66 186.6-186.6 186.6-37.2 0-71.7-10.8-100.7-29.4 5.3.6 10.4.8 15.8.8 30.7 0 58.9-10.4 81.4-28-28.8-.6-53-19.5-61.3-45.5 10.1 1.5 19.2 1.5 29.6-1.2-30-6.1-52.5-32.5-52.5-64.4v-.8c8.7 4.9 18.9 7.9 29.6 8.3a65.447 65.447 0 0 1-29.2-54.6c0-12.2 3.2-23.4 8.9-33.1 32.3 39.8 80.8 65.8 135.2 68.6-9.3-44.5 24-80.6 64-80.6 18.9 0 35.9 7.9 47.9 20.7 14.8-2.8 29-8.3 41.6-15.8-4.9 15.2-15.2 28-28.8 36.1 13.2-1.4 26-5.1 37.8-10.2-8.9 13.1-20.1 24.7-32.9 34z"></path>
                  </svg></a>
              </div>
            </div>
          </div>
        </div>
        <div class="dng-buttons">
          <button class="dng-btn-primary" data-action="generate">GENERATE NAME</button>
          <button class="dng-btn-secondary" data-action="see-all">SEE ALL</button>
        </div>
      </div>
    </div>

    <div class="dng-popup">
      <div class="dng-popup-overlay"></div>
      <div class="dng-popup-content">
        <div class="dng-popup-close">
          <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" class="svg-inline--fa fa-times fa-w-11" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg>
        </div>
        <div class="dng-popup-title">
          <h2>Names starting with \'<span class="dng-uppercase" data-action="current-letter"></span>\'</h2>
        </div>
        <div class="dng-popup-data">
          <ul class="dng-popup-letter-names" data-action="all-list">
          </ul>
        </div>
      </div>
    </div>
  </div>';
  ?>