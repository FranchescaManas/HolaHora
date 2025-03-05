<div class="row justify-content-end mb-2">
    <input type="text" name="search_fileter" id="" class="form-control w-50" placeholder="Search">
    <div class="dropdown" style="width:auto !important;">

        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            Filter
        </button>
        <form class="dropdown-menu p-4">
            <div class="mb-3">
            <label for="exampleDropdownFormEmail2" class="form-label">Position</label>
            <select name="team_filter" id="" class="form-select">
                <option value="" hidden>Select Position</option>
                <option value="" >Position 1</option>
                <option value="" >Position 2</option>
                <option value="" >Position 3</option>
                <option value="" >Position 4</option>
            </select>
            </div>
            <div class="mb-3">
            <label for="exampleDropdownFormEmail2" class="form-label">Team</label>
            <select name="team_filter" id="" class="form-select">
                <option value="" hidden>Select Team</option>
                <option value="" >Team 1</option>
                <option value="" >Team 2</option>
                <option value="" >Team 3</option>
                <option value="" >Team 4</option>
            </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>